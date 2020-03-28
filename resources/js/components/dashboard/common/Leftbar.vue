<template>
  <div>
    <v-navigation-drawer
      v-model="trigger"
      :clipped="$vuetify.breakpoint.lgAndUp"
      color="blue darken-2"
      dark
      app
    >
      <v-list dense>
        <template v-for="(item,index) in items">
          <v-row v-if="item.heading" :key="item.heading" align="center">
            <v-col cols="6">
              <v-subheader v-if="item.heading">{{ item.heading }}</v-subheader>
            </v-col>
            <v-col cols="6" class="text-center">
              <a href="#!" class="body-2 black--text">EDIT</a>
            </v-col>
          </v-row>
          <v-list-group
            v-else-if="item.children"
            :key="index"
            v-model="item.model"
            :prepend-icon="item.model ? item.icon : item['icon-alt']"
            append-icon
          >
            <template v-slot:activator>
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title>{{ item.text }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </template>
            <v-list-item
              v-for="(child, i) in item.children"
              :key="i"
              :to="handleGoToMenu('/dashboard/'+child.link)"
              v-show="showChild(child.link)"
            >
              <v-list-item-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>{{ child.text }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-group>
          <v-list-item v-else :key="item.text" :to="handleGoToMenu('/dashboard/'+item.link)">
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{ item.text }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-list>
      <template v-slot:append>
        <div class="pa-2">
          <v-btn block>Logout</v-btn>
        </div>
      </template>
    </v-navigation-drawer>
  </div>
</template>

<script>
export default {
  props: {
    trigger: false
  },
  data: () => ({
    drawer: null,
    items: [
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "dashboard",
        text: "Dashboard",
        model: false,
        children: [{ text: "Overview", link: "overview" }]
      },
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "home_work",
        text: "Property",
        model: false,
        children: [
          { text: "Property List", link: "propertylist" },
          { text: "Pending Property", link: "propertypending" },
          { text: "Add Property", link: "addproperty" },
          { text: "Cartegories", link: "categorylist" },          
          { text: "Aminities", link: "amenitylist" }
        ]
      },
          {
        icon: "keyboard_arrow_down",
        "icon-alt": "assessment",
        text: "Lead",
        model: false,
        children: [
          { text: "Lead List", link: "leadlist" },
          { text: "Add Lead", link: "leadadd" }
        ]
      },
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "account_circle",
        text: "Account",
        model: false,
        children: [
          { text: "Agent Accounts", link: "agentaccount" },
          { text: "Add Credit", link: "creaditaccountadw" }
        ]
      },
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "face",
        text: "User",
        model: false,
        children: [
          { text: "User List", link: "userlist" },
          { text: "User Type", link: "usertype" },
          { text: "Pending Users", link: "usercompletepending" },
          { text: "Pending Registration", link: "userpending" }
        ]
      },
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "brightness_high",
        text: "Settings",
        model: false,
        children: [
          { text: "Profile", link: "usersetting" },
          { text: 'Post Plan', link:'postplanlist'},
        ]
      }
    ]
  }),
  methods: {
    handleGoToMenu(d) {
      return d;
    },
    showChild(link) {
      return true;
    }
  }
};
</script>