<template>
  <div>
    <BModal ref="editNodeModal" id="edit-node-modal" title="Editar o Nó" @ok="handleOk">
      <BForm @submit.stop.prevent="handleSubmit">
        <BFormGroup label="Nome do Nó" label-for="node-name">
          <BFormInput
            id="node-name"
            v-model="editNode.name"
            required
          ></BFormInput>
        </BFormGroup>
        <BFormGroup label="Velocidade (Mbps)" label-for="speed">
          <BFormInput
            id="speed"
            type="number"
            v-model="editNode.speed"
            required
          ></BFormInput>
        </BFormGroup>
        <BFormGroup label="Custo" label-for="cost">
          <BFormInput
            id="cost"
            v-model="editNode.cost"
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
    const editNodeModal = ref(null);

    const showModal = () => {
      editNodeModal.value.show();
    };

    const hideModal = () => {
      editNodeModal.value.hide();
    };

    return {
      editNodeModal,
      showModal,
      hideModal
    };
  },
  props: {
    editNode: {
      type: Object,
      required: true
    }
  },
  data() {

  },
  methods: {
    // Manipula o evento de confirmação do modal
    handleOk(bvModalEvent) {
      bvModalEvent.preventDefault();
      this.handleSubmit();
    },
    // Manipula o envio do formulário
    handleSubmit() {
      axios.put(`/api/nodes/${this.editNode.id}`, this.editNode).then(() => {
        // Emite um evento para notificar que o nó foi editado
        this.$emit('nodeEdited');
        // Esconde o modal e reseta o formulário
        this.hideModal();
        this.resetForm();
      });
    },
    // Reseta os valores do formulário de edição do nó
    resetForm() {
      this.editNode = {
        id: 0,
        name: '',
        speed: 0,
        cost: 0.0
      };
    }
  }
};
</script>
