<template>
    <div>
      <BButton @click="showModal" variant="primary">Adicionar Conexão</BButton>
  
      <BModal ref="addConnectionModal" id="add-connection-modal" title="Adicionar Conexão na Rede" @ok="handleOk">
        <BForm @submit.stop.prevent="handleSubmit">
          <BFormGroup label="Do Nó" label-for="from-node-select">
            <BFormSelect
              id="from-node-select"
              v-model="fromNodeId"
              :options="nodeOptions"
              required
            ></BFormSelect>
          </BFormGroup>
          <BFormGroup label="Para o Nó" label-for="to-node-select">
            <BFormSelect
              id="to-node-select"
              v-model="toNodeId"
              :options="nodeOptions"
              required
            ></BFormSelect>
          </BFormGroup>
        </BForm>
        <BAlert v-if="errorMessage" :model-value="true" variant="danger" class="mt-3">{{ errorMessage }}</BAlert>
      </BModal>
    </div>
</template>
  
<script>
    import axios from 'axios';
    import { ref } from 'vue';
  
  export default {
    setup() {
        const addConnectionModal = ref(null);

        const showModal = () => {
        addConnectionModal.value.show();
        };

        const hideModal = () => {
        addConnectionModal.value.hide();
        };

        return {
          addConnectionModal,
          showModal,
          hideModal
        };
    },
    props: {
    nodes: {
      type: Array,
      required: true
    },
    connections: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      fromNodeId: null,
      toNodeId: null,
      errorMessage: ''
    };
  },
  computed: {
    nodeOptions() {
      return this.nodes.map(node => ({ value: node.id, text: node.name }));
    }
  },
  methods: {
        // Manipula o evento de confirmação do modal
        handleOk(bvModalEvt) {
            bvModalEvt.preventDefault();
            this.handleSubmit();
        },
        // Envia o formulário para adicionar a conexão
        handleSubmit() {
            // Verifica se os nós de origem e destino são os mesmos
            if (this.sameNodes()) {
                this.errorMessage = 'Para criar uma conexão, é necessário informar diferentes nós.';
                return;
            }

            // Verifica se a conexão já existe
            if (this.connectionExists()) {
                this.errorMessage = 'Já existe uma conexão entre os nós selecionados.';
                return;
            }

            // Envia a requisição para adicionar a conexão
            axios.post('/api/connections', {
                from_node_id: this.fromNodeId,
                to_node_id: this.toNodeId
            }).then(() => {
                // Emite um evento para notificar que a conexão foi adicionada
                this.$emit('connectionAdded');
                // Esconde o modal e reseta os valores do formulário e mensagem de erro
                this.hideModal();
                this.fromNodeId = null;
                this.toNodeId = null;
                this.errorMessage = '';
            });
        },
        // Verifica se os nós de origem e destino são os mesmos
        sameNodes() {
            return this.fromNodeId === this.toNodeId;
        },
        // Verifica se a conexão já existe
        connectionExists() {
            return this.connections.some(connection =>
                (connection.from_node_id === this.fromNodeId && connection.to_node_id === this.toNodeId) ||
                (connection.from_node_id === this.toNodeId && connection.to_node_id === this.fromNodeId)
            );
        }
    }
};
</script>
  
  <style scoped>
  </style>
  