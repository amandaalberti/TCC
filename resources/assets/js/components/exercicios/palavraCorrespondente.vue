<template>
	<div v-if="carregado">
		<div class="row mb-4">
			<div class="col-12 text-center">
				<h2>Selecione a palavra correspondente à imagem</h2>
			</div>
		</div>
		<div class="row justify-content-center mb-3">
			<div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center">
				<img :src="dados.respostas[0].imagem" />
			</div>
		</div>
		<div class="row">
			<div class="col-12 text-center btn-group-toggle">
				<template v-for="(p,index) in embaralhado">
					<label :class="{'btn':true, 'btn-resposta':true, 'btn-lg':true, 'mb-3':true, 'active':respostaSelecionada == index}">
						<input type="radio" name="palavraCorrespondente" v-model="respostaSelecionada" :value="index" autocomplete="off" /> {{ p.palavra }}
					</label>
					<br class="d-block d-sm-none" />
					&#x20;
				</template>
			</div>
		</div>
	</div>
</template>

<style scoped>
	img {
		max-width: 100%;
		max-height: 250px;
	}
</style>

<script type="text/javascript">
	export default {
		props: ['dados'],
		data(){
			return {
				embaralhado: [],
				indexCerta: -1,
				respostaSelecionada: -1,
				carregado: false
			};
		},
		watch: {
			dados(){
				this.indexCerta = -1;
				this.respostaSelecionada = -1;
				this.carregado = false;
				try {
					let a = [];
					a.push(this.dados.respostas[0]);
					for(let i = 0; i < 3; i++)
						a.push(this.dados.outras[i]);

					for(let i = 0; i < 4; i++)
						if(a[i] === undefined)
							throw new Error();

					this.embaralhado = this.shuffle(a);
					this.indexCerta = this.embaralhado.indexOf(this.dados.respostas[0]);
					console.log(this.indexCerta);

					Vue.nextTick(() => {
						this.$emit('carregado', true);
						this.carregado = true;
					});
				} catch (err) {
					this.$emit('carregado', false);
					this.carregado = false;
					console.error(err);
				}
			}
		},
		methods: {
			// https://stackoverflow.com/a/2450976
			shuffle(array) {
				var currentIndex = array.length, temporaryValue, randomIndex;

				// While there remain elements to shuffle...
				while (0 !== currentIndex) {

					// Pick a remaining element...
					randomIndex = Math.floor(Math.random() * currentIndex);
					currentIndex -= 1;

					// And swap it with the current element.
					temporaryValue = array[currentIndex];
					array[currentIndex] = array[randomIndex];
					array[randomIndex] = temporaryValue;
				}

				return array;
			},
			pegaResposta(){
				//todos os exercícios vão possuir esta função
				//retorna verdadeiro ou falso
				//certo ou errado
				return this.respostaSelecionada == this.indexCerta;
			}
		}
	};
</script>