<template>
    <div class="modal" :class="{ 'modal-aberto': modalAberto }">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title h4">{{ tarefa ? `Atualizar - ${tarefa.titulo}` : 'Adicionar tarefa' }}</h1>
                    <button type="button" class="close" @click="fecharModal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent.stop="handleSubmit(tarefa)">
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input required v-model="form.titulo" type="text" class="form-control" id="titulo"
                                placeholder="meu título">
                        </div>
                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea required v-model="form.descricao" class="form-control" id="descricao" rows="3"
                                placeholder="minha descrição"></textarea>
                        </div>

                        <button v-if="tarefa" type="submit" class="btn btn-warning mb-2">Atualizar</button>
                        <button v-else type="submit" class="btn btn-primary mb-2">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script lang="ts">
import TarefaResource from '@/http';
import type { Tarefa } from '@/interfaces/ITarefa';

export default {
    props: {
        modalAberto: {
            type: Boolean,
            required: true
        },
        tarefa: {
            type: Object as () => Tarefa,
            required: false
        }
    },
    data() {
        return {
            form: {
                titulo: this.tarefa?.titulo || '',
                descricao: this.tarefa?.descricao || '',
            }
        }
    },
    methods: {
        fecharModal() {
            this.$emit('fecharModal');
        },
        atualizar() {
            this.$emit('atualizar');
        },
        async createTarefa() {
            try {
                const novaTarefa: Tarefa = {
                    id: 0,
                    titulo: this.form.titulo,
                    descricao: this.form.descricao,
                    concluido: false,
                    updated_at: ''
                };

                await TarefaResource.adicionarTarefa(novaTarefa);
                this.form.titulo = '';
                this.form.descricao = '';

            } catch (error) {
                console.log('Erro ao criar tarefa:', error);
            }
        },
        editarTarefa(tarefa: Tarefa) {
            TarefaResource.atualizarTarefa(tarefa.id, tarefa)
                .then(() => {})
                .catch(error => {
                    console.error(error);
                });
        },
        async handleSubmit(tarefa?: Tarefa) {
            this.fecharModal();

            if (!tarefa) {
                await this.createTarefa();
                this.atualizar();
                return
            }
            
            tarefa.titulo = this.form.titulo
            tarefa.descricao = this.form.descricao
            
            this.editarTarefa(tarefa)
            this.atualizar();
        }
    },
    mounted() {
        this.$set(this.form, 'titulo', this.tarefa ? this.tarefa.titulo : '');
        this.$set(this.form, 'descricao', this.tarefa ? this.tarefa.descricao : '');
    },


};
</script>
  
<style lang="scss">
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-aberto {
    display: block;
}

.modal-dialog {
    position: relative;
    margin: 10% auto;
    padding: 20px;
    max-width: 600px;
}

.modal-content {
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}

.modal-title {
    margin: 0;
}

.modal-body {
    padding: 20px 0;

    .title-config {
        display: flex;
        align-items: center;
        justify-content: space-between;


        .time {
            color: #999;
            font-size: small;
        }
    }

    .description {
        color: #555;
    }
}

.modal-footer {
    display: flex;
    justify-content: space-between;
    border-top: 1px solid #ddd;
    padding: 10px 0;
    text-align: right;
}
</style>
  