<template>
    <v-app-bar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      color="blue darken-2"
      dark
    >
      <v-toolbar-title
        style="width: 300px"
        class="ml-0 pl-4"
      >
        <v-app-bar-nav-icon @click="drawerTrigger"></v-app-bar-nav-icon>
        <span class="hidden-sm-and-down">Homyfi</span>
      </v-toolbar-title>
      <v-progress-linear
        :active="showFullLoading"
        :indeterminate="showFullLoading"
        absolute
        bottom
        color="white"
      ></v-progress-linear>
      <v-text-field
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="search"
        label="Search"
        class="hidden-sm-and-down"
      ></v-text-field>
      <div class="flex-grow-1"></div>
      <v-btn icon>
        <v-icon>mdi-apps</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon>mdi-bell</v-icon>
      </v-btn>
      <v-btn
        icon
        large
      >
        <v-avatar
          size="32px"
          item
        >
          <v-img
            src="https://cdn.vuetifyjs.com/images/logos/logo.svg"
            alt="Vuetify"
          >
          </v-img></v-avatar>
      </v-btn>
      <template v-slot:extension>
        <v-tabs
          centered
          background-color="transparent"
        >
          <v-tab 
          v-for="(tab,index) in tabList"
          :key="index"
          >
            {{tab.name}}
            <v-btn text icon @click="removeTab(index)">   
              <v-icon>close</v-icon>
            </v-btn>
          </v-tab>
        </v-tabs>
      </template>
    </v-app-bar>
</template>

<script>
  export default {
    props: {
      source: String,
    },
    data: () => ({
      drawer:false,
      dialog: false,
      tabList:
      [
        {
          name:'Property'
        },
        {
          name:'Category'
        },
        {
          name:'User'
        },
        {
          name:'Property'
        },
        {
          name:'Category'
        },
        {
          name:'User'
        },
        {
          name:'Property'
        },
        {
          name:'Category'
        },
        {
          name:'User'
        },
        {
          name:'Property'
        },
        {
          name:'Category'
        },
        {
          name:'User'
        },
        {
          name:'Property'
        },
        {
          name:'Category'
        },
        {
          name:'User'
        },
      ]
      
    }),
    methods:
    {
      removeTab(index)
      {
        this.tabList.splice(index,1);
      },
      drawerTrigger()
      {
          this.drawer=!this.drawer;
          this.$emit('send',this.drawer)
      }
    }
  }
</script>