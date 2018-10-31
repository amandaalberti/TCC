<template>
	<div>
		<loading v-if="loading && !mostraFeedback"></loading>

		<div class="text-center" v-if="mostraFeedback">
			<img width="350" :src="caminhoImagemFeedback" />
			<h1 v-html="textoFeedback"></h1>
		</div>

		<div v-show="!loading && !mostraFeedback">
			<!-- Colocar aqui um elemento de cada tipo de exercício/componente Vue -->
			<exercicio-palavra-correspondente ref="1" v-if="tipo == 1" @carregado="carregado" :dados="dados[1]"></exercicio-palavra-correspondente>
			<exercicio-quantidade-silabas ref="2" v-if="tipo == 2" @carregado="carregado" :dados="dados[2]"></exercicio-quantidade-silabas>
			<exercicio-letra-faltante ref="3" v-if="tipo == 3" @carregado="carregado" :dados="dados[3]"></exercicio-letra-faltante>

			<div class="text-center mt-5">
				<button type="button" class="btn btn-primary btn-lg" @click.prevent="proximoExercicio">Continuar</button>
				<button type="button" class="btn btn-danger btn-lg" @click.prevent="voltaPaginaPrincipal">Sair</button>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		data(){
			return {
				dados: {
					1: {}, //Palavra Correspondente
					2: {}, //Quantidade de sílabas
					3: {}  //Letra faltante
				},
				tipo: 0,
				mostraFeedback: false,
				caminhoImagemFeedback: "",
				textoFeedback: "",
				//os exercícios serão separados por tipo, que será um número indicando o tipo
				//nesse arquivo será gerado um número randômico que indicará o tipo do exercício a ser criado
				//será feito um ajax para gerar os dados aleatoriamente, que conterá a letra relacionada
				//esse ajax receberá parâmetros para gerar uma quantidade de respostas certas e uma quantidade de respostas erradas.
				loading: true
			};
		},
		mounted(){
			this.geraExercicio();
		},
		methods: {
			geraExercicio(){
				this.loading = true;

				this.tipo = _.sample([1,2,3]); //seleção do exercício

				let certas = 1;
				let erradas = 3;

				if(this.tipo == 2 || this.tipo == 3)
					erradas = 0;

				axios.get(addr + "/exercicios/dados/" + certas + "/" + erradas).then(response => {
					this.dados[this.tipo] = response.data;
					console.log(this.dados[this.tipo]);

					response = null;
				},
				error => {
					console.error("Erro");
					console.dir(error);
				});
			},
			carregado(r){
				//exercício carregado

				if(r)
					this.loading = false;
				//else
				//gerenciar erro aqui?
			},
			async feedback(acertou){
				let quantidadeImagensAcerto = 5;
				let quantidadeImagensErro = 2;

				let baseCaminhoImagem = addr + "/gif/";

				let imagens = [];

				if(acertou){
					let audio = new Audio(addr + '/wav/aplausos.wav');
					audio.play();
					for(let i = 1; i <= quantidadeImagensAcerto; i++)
						imagens.push(i);
					this.textoFeedback = "Parabéns,<br />você acertou!";
					this.caminhoImagemFeedback = baseCaminhoImagem + "positivo" + _.sample(imagens) + ".gif";
				} else {
					let audio = new Audio(addr + '/wav/erro.wav');
					audio.play();
					for(let i = 1; i <= quantidadeImagensErro; i++)
						imagens.push(i);
					this.textoFeedback = "Tente na próxima,<br />você consegue!";
					this.caminhoImagemFeedback = baseCaminhoImagem + "errado" + _.sample(imagens) + ".gif";
				}
				this.mostraFeedback = true;
				setTimeout(() => {
					this.mostraFeedback = false;
				}, 4000);
			},
			proximoExercicio(){
				this.loading = true;

				let r = this.$refs[this.tipo].pegaResposta();

				this.feedback(r);

				axios.post(addr + "/exercicios/grava-resultado", {
					tipo: this.tipo,
					letra: this.dados[this.tipo].letra,
					acertou: r
				}).then(() => {
					this.geraExercicio();
				}, error => {
					console.error('Erro proximoExercicio');
					console.dir(error);
				});
			},
			voltaPaginaPrincipal(){
				window.location = addr + '/inicio';
			}
		}
	};
</script>