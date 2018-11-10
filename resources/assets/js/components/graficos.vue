<template>
	<div>
		<table style="width:100%">
			<tbody>
				<tr>
					<td>
						<h1 class="page-header">Alunos <i class="fa fa-angle-double-right"></i> Gráfico</h1>
					</td>
					<td>
						<div class="row">
							<div class="col-12 text-right">
								<form class="form-inline">
									<div class="pull-right" style="width:100%">
										<date-picker :config="{locale:'pt-br', useStrict:true, format:'DD/MM/YYYY', useCurrent: false, defaultDate: ''}" placeholder="Data Inicial" v-model="dataInicial" class="mr-2"></date-picker>
										<date-picker :config="{locale:'pt-br', useStrict:true, format:'DD/MM/YYYY', useCurrent: false, defaultDate: ''}" placeholder="Data Final" v-model="dataFinal" class="mr-2"></date-picker>
										<select class="form-control mr-2" v-model="tipo">
											<option value="0">Tipo do Exercício</option>
											<option v-for="(t, i) in tipos" :value="i">{{ t }}</option>
										</select>
										<button class="btn btn-info btn-xlg mr-2" type="button" @click.prevent="getDados"><i class="fa fa-search"></i> Filtrar</button>
										<button class="btn btn-tomato btn-xlg mr-2" type="button" onClick="history.back();"><i class="fa fa-arrow-left"></i> Voltar</button>
									</div>
								</form>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2"><h2>{{ nomeAluno }}</h2></td>
				</tr>
			</tbody>
		</table>

		<div style="overflow-x:auto!important">
			<highcharts ref="grafico" :options="options"></highcharts>
		</div>

		<div style="overflow-x:auto!important">
			<loading v-if="loading"></loading>
			<table-component v-if="!loading" :data="dados" :show-filter="false" :show-caption="false" cache-lifetime="0">
	            <table-column cell-class="padding-0" show="tipo" label="Tipo do Exercício">
	                <template slot-scope="row"><div :class="(row.acertou == 1 ? 'table-success' : 'table-danger') + ' full'">{{ tipos[row.tipo] }}</div></template>
	            </table-column>
	            <table-column cell-class="padding-0" show="letra" label="Letra Associada">
	            	<template slot-scope="row"><div :class="(row.acertou == 1 ? 'table-success' : 'table-danger') + ' full'">{{ row.letra }}</div></template>
	            </table-column>
	            <table-column cell-class="padding-0" show="palavra" label="Palavra">
	            	<template slot-scope="row"><div :class="(row.acertou == 1 ? 'table-success' : 'table-danger') + ' full'">{{ row.palavra }}</div></template>
	            </table-column>
	            <table-column cell-class="padding-0" show="resposta_certa" label="Resposta Certa">
	            	<template slot-scope="row"><div :class="(row.acertou == 1 ? 'table-success' : 'table-danger') + ' full'">{{ row.resposta_certa }}</div></template>
	            </table-column>
	            <table-column cell-class="padding-0" show="resposta_selecionada" label="Resposta Selecionada">
	            	<template slot-scope="row"><div :class="(row.acertou == 1 ? 'table-success' : 'table-danger') + ' full'">{{ row.resposta_selecionada }}</div></template>
	            </table-column>
	            <table-column cell-class="padding-0" show="data" label="Data da Resposta">
	            	<template slot-scope="row"><div :class="(row.acertou == 1 ? 'table-success' : 'table-danger') + ' full'">{{ row.data }}</div></template>
	            </table-column>
	        </table-component>
	    </div>
	</div>
</template>

<style type="text/css">
	.padding-0 {
		padding: 0 !important;
	}
	.full {
		width: 100% !important;
		height: 100% !important;
		padding: 0.75rem;
		white-space: nowrap;
	}
</style>

<script type="text/javascript">
	export default {
		props: ['idAluno', 'nomeAluno'],
		data(){
			return {
				options: {
					chart: {
						type: 'column',
						panning: true,
						panKey: 'ctrl',
						zoomType: 'xy'
					},
					colors: ["#00FF00", "#FF0000", "#90ed7d", "#f7a35c", "#8085e9", "#f15c80", "#e4d354", "#2b908f", "#f45b5b", "#91e8e1"],
					credits: {
						enabled: false
					},
					title: {
						text: 'Acertos e Erros Por Letra'
					},
					subtitle: {
						text: ''
					},
					xAxis: {
						categories: ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'],
					},
					yAxis: {
						title: {
							text: 'Quantidade'
						},
						gridLineColor: '#ccc',
						min: 0,
						allowDecimals: false
					},
					tooltip: {
						formatter: function(){
							return '<b>' + this.series.name + '</b><br> ' + this.y;
						}
					},
					series: []
				},
				tipo: 0,
				dataInicial: '',
				dataFinal: '',
				loading: false,
				dados: [],
				tipos: {
					1: 'Palavra Correspondente',
					2: 'Quantidade de Sílabas',
					3: 'Letra Faltante'
				}
			};
		},
		mounted(){
			this.getDados();
		},
		methods: {
			getDados(){
				if(this.dataInicial == '' || this.dataFinal == ''){
					let data = new Date();

					this.dataFinal = this.formataData(data);

					data.setDate(data.getDate() - 30);

					this.dataInicial = this.formataData(data);
				}
				this.loading = true;
				this.$refs.grafico.chart.showLoading();
				axios.post(addr + '/alunos/graficos/' + this.idAluno + '/dados', {
					tipo: this.tipo,
					dataInicial: this.dataInicial,
					dataFinal: this.dataFinal
				}).then(response => {
					this.options.series = response.data.series;
					this.dados = response.data.resultados || [];

					response = null;

					this.options.title.text = 'Acertos e Erros Por Letra - De ' + this.dataInicial + ' Até ' + this.dataFinal;

					this.loading = false;
				},
				error => {
					console.error('Erro');
					console.dir(error);
				});
			},
			formataData(a){
				return a.getDate() + '/' + ("0" + (a.getMonth() + 1)).slice(-2) + '/' + a.getFullYear();
			}
		}
	};
</script>