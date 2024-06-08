<template>
    <div>
        <sidebar-menu
          v-if="$route.name !== 'login' && $route.name !== 'index'"
          v-model="collapsed"
          :menu="menu"
          :theme="selectedTheme"
          :show-one-child="true"
          @update:collapsed="onToggleCollapse"
          @item-click="onItemClick"
        />
        <div
          v-if="isOnMobile && !collapsed"
          class="sidebar-overlay"
          @click="collapsed = true"
        />
        <div id="demo" :class="[{ collapsed: collapsed }, { onmobile: isOnMobile }, { padding: $route.name !== 'login' && $route.name !== 'index'  }]">
          <div class="demo">
            <div class="container">
              <router-view />
            </div>
          </div>
        </div>
    </div>
  </template>
  
  <script>
  import { h } from 'vue'
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
  
  const separator = h('hr', {
    style: {
      borderColor: 'rgba(0, 0, 0, 0.1)',
      margin: '20px',
    },
  })
  
  const faIcon = (props) => {
    return {
      element: h('div', [h(FontAwesomeIcon, { size: 'lg', ...props })]),
    }
  }
  
  export default {
    name: 'App',
    data() {
      return {
        menu: [
          {
            header: 'PAINEL',
            hiddenOnCollapse: true,
          },
          {
            href: '/dashboard',
            title: 'Dashboard',
            icon: faIcon({ icon: 'fa-solid fa-download' }),
          },
          {
            href: '/diagram',
            title: 'Diagrama da Rede',
            icon: faIcon({ icon: 'fa-solid fa-palette' }),
          },
          {
            href: '/node-list',
            title: 'Nós',
            icon: faIcon({ icon: 'fa-solid fa-bell' }),
          },
          {
            href: '/connections-list',
            title: 'Conexões',
            icon: faIcon({ icon: 'fa-solid fa-cogs' }),
          },
          {
            title: 'Sair',
            icon: faIcon({ icon: 'fa-solid fa-cubes' }),
          },
        ],
        collapsed: false,
        selectedTheme: 'white-theme',
        isOnMobile: false,
      }
    },
    mounted() {
      this.onResize()
      window.addEventListener('resize', this.onResize)
    },
    methods: {
      onToggleCollapse(collapsed) {
        console.log('onToggleCollapse')
      },
      onItemClick(event, item) {
        if (item.title == 'Sair') {
          localStorage.removeItem('token');
          this.$router.push({ name: 'login' });
        }
      },
      onResize() {
        if (window.innerWidth <= 767) {
          this.isOnMobile = true
          this.collapsed = true
        } else {
          this.isOnMobile = false
          this.collapsed = false
        }
      },
    },
  }
  </script>
  
  <style lang="scss">
  @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600');
  
  body,
  html {
    margin: 0;
    padding: 0;
  }
  
  body {
    font-family: 'Source Sans Pro', sans-serif;
    font-size: 18px;
    background-color: #f1f0f0;
    color: #262626;
  }

  .padding{
    padding-left: 290px;
  }
  
  #demo {
    transition: 0.3s ease;
    background-color: #f1f0f0;
    height: 100vh;
    overflow: hidden;
  }

  #demo.collapsed {
    padding-left: 65px;
  }
  #demo.onmobile {
    padding-left: 65px;
  }
  
  .sidebar-overlay {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background-color: #000;
    opacity: 0.5;
    z-index: 900;
  }
  
  .demo {
    padding: 50px;
  }
  
  .container {
    max-width: 900px;
  }
  </style>