<template>
    <div class="dashboard">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ nodeCount }}</h3>
                        <p>Total de Nós</p>
                    </div>
                    <div class="icon">
                        <font-awesome-icon :icon="['fas', 'network-wired']" />
                    </div>
                    <a href="/node-list" class="small-box-footer">
                        More info <font-awesome-icon :icon="['fas', 'arrow-circle-right']" />
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3>{{ connectionCount }}</h3>
                        <p>Total de Conexões</p>
                    </div>
                    <div class="icon">
                        <font-awesome-icon :icon="['fas', 'link']" />
                    </div>
                    <a href="/connections-list" class="small-box-footer">
                        More info <font-awesome-icon :icon="['fas', 'arrow-circle-right']" />
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-warning">
                    <div class="inner">
                        <h3>{{ totalCost }}</h3>
                        <p>Custo Total da Rede</p>
                    </div>
                    <div class="icon">
                        <font-awesome-icon :icon="['fas', 'dollar-sign']" />
                    </div>
                    <a href="/node-list" class="small-box-footer">
                        More info <font-awesome-icon :icon="['fas', 'arrow-circle-right']" />
                    </a>
                </div>
            </div>
        </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
  
  export default {
    components: {
        'font-awesome-icon': FontAwesomeIcon,
    },
    data() {
      return {
        nodeCount: 0,
        connectionCount: 0,
        totalCost: 0,
      };
    },
    methods: {
        // Método para buscar e atualizar as estatísticas
        fetchStats() {
            // Requisição para obter o total de nós
            axios.get('/api/nodes').then(response => {
                this.nodeCount = response.data.length;
                // Calcula o custo total da rede somando os custos de todos os nós
                this.totalCost = response.data.reduce((sum, node) => sum + parseFloat(node.cost), 0).toFixed(2);
            });
            // Requisição para obter o total de conexões
            axios.get('/api/connections').then(response => {
                this.connectionCount = response.data.length;
            });
        }
    },
    mounted() {
        // Ao montar o componente, buscar as estatísticas
        this.fetchStats();
    }
  };
  </script>
  
  <style scoped>
  .dashboard {
    padding: 20px;
  }
  
  .card {
    text-align: center;
  }
  </style>
  