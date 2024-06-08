<template>
  <div>
    <BButton @click="showModal" variant="primary">Adicionar Nó</BButton>

    <BModal ref="addNodeModal" id="add-node-modal" title="Adicionar Nó na Rede" @ok="handleOk">
      <BForm @submit.stop.prevent="handleSubmit">
        <BFormGroup label="Nome do Nó" label-for="node-name">
          <BFormInput
            id="node-name"
            v-model="newNode.name"
            required
          ></BFormInput>
        </BFormGroup>
        <BFormGroup label="Velocidade (Mbps)" label-for="speed">
          <BFormInput
            id="speed"
            type="number"
            v-model="newNode.speed"
            required
          ></BFormInput>
        </BFormGroup>
        <BFormGroup label="Custo" label-for="cost">
          <BFormInput
            id="cost"
            v-model="newNode.cost"
            required
          ></BFormInput>
        </BFormGroup>
      </BForm>
    </BModal>
  </div>
</template>

<script>
import axios from 'axios';
import { ref } from 'vue';

export default {
  setup() {
    const addNodeModal = ref(null);

    const showModal = () => {
      addNodeModal.value.show();
    };

    const hideModal = () => {
      addNodeModal.value.hide();
    };

    return {
      addNodeModal,
      showModal,
      hideModal
    };
  },
  data() {
    return {
      newNode: {
        name: '',
        speed: 0,
        cost: 0.0
      }
    };
  },
  methods: {
    // Manipula o evento de confirmação do modal
    handleOk(bvModalEvent) {
      bvModalEvent.preventDefault();
      this.handleSubmit();
    },
    // Envia o formulário para adicionar o nó
    handleSubmit() {
      axios.post('/api/nodes', this.newNode).then(() => {
        // Emite um evento para notificar que o nó foi adicionado
        this.$emit('nodeAdded');
        // Esconde o modal e reseta o formulário
        this.hideModal();
        this.resetForm();
      });
    },
    // Reseta o formulário de adicionar nó
    resetForm() {
      this.newNode = {
        name: '',
        speed: 0,
        cost: 0.0
      };
    }
  }
};
</script>
