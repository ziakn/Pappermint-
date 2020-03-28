<template>
  <v-app>
    <router-view></router-view>
  </v-app>
</template>

<script>
export default {
    data: () => ({
      isLeftbar:false
      
    }),
    components:
    {
    },
    methods:{
      headerGet(item)
      {
          this.isLeftbar=item
      }

    }
  }
</script>