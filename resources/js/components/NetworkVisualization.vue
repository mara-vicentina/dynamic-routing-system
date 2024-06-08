<template>
  <div>
    <BRow>
      <BCol>
        <h2>Diagrama de Rede</h2>
        <div id="network" class="mt-3"></div>
      </BCol>
    </BRow>
  </div>
</template>

<script>
import axios from 'axios';
import * as d3 from 'd3';

export default {
  data() {
    return {
      nodes: [],
      connections: [],
      selectedNodes: []
    };
  },
  methods: {
    // Busca a lista de nós da API e atualiza a visualização
    fetchNodes() {
      axios.get('/api/nodes').then(response => {
        this.nodes = response.data;
        this.updateVisualization();
      });
    },
    // Busca a lista de conexões da API e atualiza a visualização
    fetchConnections() {
      axios.get('/api/connections').then(response => {
        this.connections = response.data.map(connection => ({
          ...connection,
          source: connection.from_node_id,
          target: connection.to_node_id
        }));
        this.updateVisualization();
      });
    },
    // Atualiza a visualização do diagrama de rede usando D3.js
    updateVisualization() {
      const svg = d3.select("#network").selectAll("*").remove().exit().remove();

      const width = document.getElementById('network').clientWidth;
      const height = document.getElementById('network').clientHeight;

      const svgElement = d3.select("#network").append("svg")
        .attr("width", width)
        .attr("height", height)
        .call(d3.zoom().on("zoom", function(event) {
          svgElement.attr("transform", event.transform);
        }))
        .append("g");

      const simulation = d3.forceSimulation(this.nodes)
        .force("link", d3.forceLink(this.connections).id(d => d.id).distance(100))
        .force("charge", d3.forceManyBody().strength(-300))
        .force("center", d3.forceCenter(width / 2, height / 2))
        .on("tick", ticked);

      const link = svgElement.append("g")
        .attr("class", "links")
        .selectAll("line")
        .data(this.connections)
        .enter().append("line")
        .attr("stroke-width", d => Math.sqrt(d.cost))
        .attr("stroke", "#999");

      const node = svgElement.append("g")
        .attr("class", "nodes")
        .selectAll("circle")
        .data(this.nodes)
        .enter().append("circle")
        .attr("r", 10)
        .attr("fill", d => this.selectedNodes.includes(d) ? "red" : "#69b3a2")
        .call(d3.drag()
          .on("start", dragStarted)
          .on("drag", dragged)
          .on("end", dragEnded));

      const labels = svgElement.append("g")
        .attr("class", "labels")
        .selectAll("text")
        .data(this.nodes)
        .enter().append("text")
        .attr("dy", -15)
        .attr("text-anchor", "middle")
        .attr("fill", "#333")
        .text(d => `${d.name}\nIP: ${d.ip_address}\nSpeed: ${d.speed} Mbps`);

      // Função chamada a cada "tick" da simulação para atualizar posições de nós e links
      function ticked() {
        link
          .attr("x1", d => d.source.x)
          .attr("y1", d => d.source.y)
          .attr("x2", d => d.target.x)
          .attr("y2", d => d.target.y);

        node
          .attr("cx", d => d.x)
          .attr("cy", d => d.y);

        labels
          .attr("x", d => d.x)
          .attr("y", d => d.y);
      }

      // Função chamada quando o arrasto de um nó começa
      function dragStarted(event, d) {
        if (!event.active) simulation.alphaTarget(0.3).restart();
        d.fx = d.x;
        d.fy = d.y;
      }

      // Função chamada enquanto um nó está sendo arrastado
      function dragged(event, d) {
        d.fx = event.x;
        d.fy = event.y;
      }

      // Função chamada quando o arrasto de um nó termina
      function dragEnded(event, d) {
        if (!event.active) simulation.alphaTarget(0);
        d.fx = null;
        d.fy = null;
      }
    },
  },
  // Carrega a lista de nós e conexões quando o componente é montado
  mounted() {
    this.fetchNodes();
    this.fetchConnections();
  },
}
</script>

<style scoped>
#network {
  width: 100%;
  height: 500px;
  background-color: white;
}
</style>
