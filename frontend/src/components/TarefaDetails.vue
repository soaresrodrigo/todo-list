<template>
    <div class="modal" :class="{ 'modal-aberto': modalAberto }">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title h4">{{ tarefa.titulo }}</h1>
                    <button type="button" class="close" @click="fecharModalDetalhes">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="title-config">
                        <div class="time">Atualizado em {{ formatarData(tarefa.updated_at) }}</div>
                    </div>
                    <div class="description mt-3">
                        {{ tarefa.descricao }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <TarefaForm :modal-aberto="modalFormulario" @fecharModal="fecharModal" @atualizar="carregarTarefas" /> -->
</template>
  
<script lang="ts">
import type { Tarefa } from '@/interfaces/ITarefa';
import TarefaForm from './TarefaForm.vue';

export default {
    data() {
        return {
            modalFormulario: false
        }
    },
    props: {
        modalAberto: {
            type: Boolean,
            required: true
        },
        tarefa: {
            type: Object as () => Tarefa,
            required: true
        },
        fecharModal: {
            type: Function,
            required: false
        }
    },
    components: {
        TarefaForm
    },
    methods: {
        fecharModalDetalhes() {
            this.$emit('fechar');
        },

        padLeft(value: string, length: number, char: string): string {
            while (value.length < length) {
                value = char + value;
            }
            return value;
        },

        formatarData(data: string): string {
            const date = new Date(data);
            const dia = this.padLeft(date.getDate().toString(), 2, '0');
            const mes = this.padLeft((date.getMonth() + 1).toString(), 2, '0');
            const ano = date.getFullYear();
            const hora = this.padLeft(date.getHours().toString(), 2, '0');
            const minuto = this.padLeft(date.getMinutes().toString(), 2, '0');

            return `${dia}/${mes}/${ano} - ${hora}:${minuto}`;
        },

        editarTarefa() {
            this.fecharModalDetalhes();
            this.modalFormulario = true;
        }


    }
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
        justify-content: end;

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
  