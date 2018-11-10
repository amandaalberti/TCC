<template>
	<div v-if="carregado">
		<div class="row mb-4">
			<div class="col-12 text-center">
				<h2>Qual letra está faltando?</h2>
			</div>
		</div>
		<div class="row justify-content-center mb-4">
			<div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center">
				<img :src="dados.resposta.imagem" />
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-12 text-center">
				<h1>{{ palavra }}</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-12 text-center btn-group-toggle">
				<template v-for="(l,index) in embaralhado">
					<label :class="{'btn':true, 'btn-resposta':true, 'btn-lg':true, 'mb-3':true, 'active':respostaSelecionada == index}">
						<input type="radio" name="palavraCorrespondente" v-model="respostaSelecionada" :value="index" autocomplete="off" /> {{ l }}
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
				carregado: false,
				palavra: ''
			};
		},
		watch: {
			dados(){
				this.indexCerta = -1;
				this.respostaSelecionada = -1;
				this.carregado = false;
				try {
					if(this.dados.resposta === undefined)
						throw new Error();

					let letras = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
					letras.splice(letras.indexOf(this.dados.letra), 1);

					let a = [];
					a.push(this.dados.letra);
					let i = 0;
					while(i < 3){
						let n = _.sample(letras);
						a.push(n);
						let index = letras.indexOf(n);
						letras.splice(index, 1);

						i++;
					}

					this.embaralhado = this.shuffle(a);
					this.indexCerta = this.embaralhado.indexOf(this.dados.letra);
					console.log(this.indexCerta);

					let p = this.dados.resposta.palavra.split("");
					let indexes = [];
					for(i = 0; i < p.length; i++)
						if(p[i].toLocaleLowerCase("pt-BR").localeCompare(this.dados.letra.toLocaleLowerCase("pt-BR"), "pt-BR", {sensitivity: 'base'}) === 0)
							indexes.push(i);
					let index = _.sample(indexes);

					p[index] = '_';
					this.palavra = p.join("");

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