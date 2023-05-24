<template>
    <div class="content">
        <div>
            <h1>Lista de Tarefas</h1>
            <p class="text-secondary text-center">Clique no título de cada tarefa para visualizar os detalhes</p>
        </div>
        <div>
            <button class="btn btn-primary d-block" @click="abrirModal('cadastrar')"> + ADICIONAR TAREFA</button>
        </div>

        <section class="lists">
            <article>
                <h2>Para Fazer</h2>
                <div class="message-empty" v-if="tarefasParaFazer.length === 0">
                    <p>
                        No momento, não existe nenhuma tarefa para ser feita.

                    </p>
                    <p>
                        <button class="btn btn-outline-primary btn-sm" @click="abrirModal('cadastrar')"> + ADICIONAR TAREFA</button>
                    </p>
                </div>
                <ul>
                    <li v-for="(tarefa) in tarefasParaFazer" :key="tarefa.id">
                        <div class="title" @click="abrirModal('detalheTarefasParaFazer', tarefa.id)">{{ tarefa.titulo }}
                        </div>
                        <div class="action">
                            <div @click="mudarStatusDaTarefa(tarefa)" title="Concluir tarefa">
                                <IconSquare />
                            </div>

                            <div @click="abrirModal('editar', tarefa.id)" title="Editar tarefa">
                                <IconEdit />
                            </div>

                            <div @click="excluirTarefa(tarefa.id)" title="Excluir tarefa">
                                <IconDelete />
                            </div>
                        </div>
                    </li>
                </ul>
            </article>
            <article>
                <h2>Feitos</h2>
                <div class="message-empty" v-if="tarefasFeitas.length === 0">
                    No momento, não existe nenhuma tarefa concluída.
                </div>
                <ul>
                    <li v-for="(tarefa) in tarefasFeitas" :key="tarefa.id">
                        <div class="title" @click="abrirModal('detalheTarefasFeitas', tarefa.id)">{{ tarefa.titulo }}</div>

                        <div class="action">
                            <div @click="mudarStatusDaTarefa(tarefa)" title="Reabrir tarefa">
                                <IconUndoTask />
                            </div>

                            <div @click="abrirModal('editar', tarefa.id)" title="Editar tarefa">
                                <IconEdit />
                            </div>
                            <div @click="excluirTarefa(tarefa.id)" title="Deletar tarefa">
                                <IconDelete />
                            </div>
                        </div>

                    </li>
                </ul>

            </article>
        </section>

        <!-- Modais -->
        <TarefaForm :modal-aberto="modalFormularioCadastrar" @fecharModal="fecharModal('cadastrar')"
            @atualizar="carregarTarefas" />
        <TarefaForm v-if="modalFormularioEditar" :modal-aberto="modalFormularioEditar" @fecharModal="fecharModal('editar')"
            @atualizar="carregarTarefas" :tarefa="tarefaSelecionada" />
        <TarefaDetails :modal-aberto="modalTarefaAbertoParaFazer" :tarefa="tarefaSelecionada"
            @fechar="fecharModal('detalheTarefasParaFazer')" />
        <TarefaDetails :modal-aberto="modalTarefaAbertoFeitos" :tarefa="tarefaSelecionada"
            @fechar="fecharModal('detalheTarefasFeitas')" />
    </div>
</template>

<script lang="ts">
import TarefaResource from '@/http';
import type { Tarefa } from '@/interfaces/ITarefa';
import TarefaDetails from './TarefaDetails.vue';
import TarefaForm from './TarefaForm.vue';
import IconSquare from '@/components/icons/IconSquare.vue'
import IconEdit from '@/components/icons/IconEdit.vue'
import IconDelete from '@/components/icons/IconDelete.vue'
import IconUndoTask from '@/components/icons/IconUndoTask.vue'
type secaoModal = 'editar' | 'cadastrar' | 'detalheTarefasFeitas' | 'detalheTarefasParaFazer';

export default {
    components: {
        TarefaDetails,
        TarefaForm,
        IconSquare,
        IconEdit,
        IconDelete,
        IconUndoTask
    },
    data() {
        return {
            tarefas: [] as Tarefa[],
            tarefasParaFazer: [] as Tarefa[],
            tarefasFeitas: [] as Tarefa[],
            tarefaSelecionada: {} as Tarefa,
            modalTarefaAbertoParaFazer: false,
            modalTarefaAbertoFeitos: false,
            modalFormularioCadastrar: false,
            modalFormularioEditar: false
        };
    },
    mounted() {
        this.carregarTarefas();
    },
    methods: {
        carregarTarefas() {
            this.tarefasFeitas = [];
            this.tarefasParaFazer = [];
            TarefaResource.getTarefas()
                .then((response: Tarefa[]) => {
                    this.tarefas = response;
                    this.tarefas.forEach((tarefa) => {
                        if (tarefa.concluido) {
                            this.tarefasFeitas.push(tarefa);
                            return
                        }
                        this.tarefasParaFazer.push(tarefa);
                    });
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        abrirModal(secao: secaoModal, tarefaId?: number) {
            const tarefaSelecionada = this.tarefas.filter(a => a.id === tarefaId!)[0];
            switch (secao) {
                case 'detalheTarefasParaFazer':
                    this.tarefaSelecionada = tarefaSelecionada;
                    this.modalTarefaAbertoParaFazer = true;
                    break;
                case 'detalheTarefasFeitas':
                    this.tarefaSelecionada = tarefaSelecionada;
                    this.modalTarefaAbertoFeitos = true;
                    break;
                case 'editar':
                    this.tarefaSelecionada = tarefaSelecionada;
                    this.modalFormularioEditar = true;
                    break;
                case 'cadastrar':
                    this.modalFormularioCadastrar = true;
                    break;
                default:
                    break;
            }
        },
        fecharModal(secao: secaoModal) {
            switch (secao) {
                case 'detalheTarefasParaFazer':
                    this.modalTarefaAbertoParaFazer = false;
                    break;
                case 'detalheTarefasFeitas':
                    this.modalTarefaAbertoFeitos = false;
                    break;
                case 'cadastrar':
                    this.modalFormularioCadastrar = false;
                    break;
                case 'editar':
                    this.modalFormularioEditar = false;
                default:
                    break;
            }
        },
        mudarStatusDaTarefa(tarefa: Tarefa) {
            tarefa.concluido = !tarefa.concluido;

            TarefaResource.atualizarTarefa(tarefa.id, tarefa)
                .then(() => {
                    this.carregarTarefas();
                })
                .catch(error => {
                    console.error(error);
                });
        },
        excluirTarefa(tarefaId: number) {
            if (!confirm('Tem certeza que deseja excluir?')) {
                return;
            }
            TarefaResource.excluirTarefa(tarefaId)
                .then(() => {
                    this.carregarTarefas();
                })
                .catch(error => {
                    console.error(error);
                });
        },
    }
};
</script>



<style lang="scss">
.content {
    display: flex;
    flex-direction: column;
    gap: 50px;
    padding: 20px 10px;
    min-height: 100vh;

    h1 {
        text-align: center;
    }

}


.lists {
    display: flex;
    max-width: 100%;
    gap: 30px;
    justify-content: space-between;

    .message-empty {
        text-align: center;
        color: #999;
    }

    article {
        background-color: #eeeef2;
        width: 100%;
        max-width: 49%;
        height: 60vh;
        display: flex;
        flex-direction: column;
        padding: 20px;
        gap: 30px;
        border-radius: 10px;

        ul {
            display: flex;
            overflow: auto;
            flex-direction: column;
            gap: 5px;
            list-style: none;

            li {
                display: flex;
                gap: 10px;
                align-items: center;

                .title {
                    cursor: pointer;
                    padding: 5px;
                    border-radius: 5px;
                    display: block;
                    background-color: #cccbcb;
                    width: 90%;
                }

                .action {
                    display: flex;
                    width: auto;
                    gap: 5px;
                    cursor: pointer;

                    svg {
                        width: 24px;
                        height: 24px;
                        opacity: .4;
                        transition: .3s;

                        &:hover {
                            opacity: 1;
                        }
                    }
                }
            }
        }
    }

    @media (max-width: 1000px) {
        flex-direction: column;

        article {
            max-width: 100%;
        }

    }
}
</style>