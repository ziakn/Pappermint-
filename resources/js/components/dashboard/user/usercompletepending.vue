<template>
  <v-content>
    <v-container fluid>
      <v-overlay :value="showFullLoading" :absolute="absolute">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <v-row justify="center">
        <v-col sm="12" md="12" lg="11">
          <v-toolbar flat color="white">
            <v-toolbar-title>Agent List</v-toolbar-title>
            <v-divider class="mx-2" inset vertical></v-divider>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="800px">
              <EditAgent :editedItem="editedItem" @dialog="editChange"></EditAgent>



            </v-dialog>
          </v-toolbar>
          <v-data-table :headers="headers" :items="dataUser" class="elevation-1">
            <template v-slot:item.status="{ item }">
              <v-chip :color="item.status==1?'green':'red'" text-color="white">
                <span v-if="item.status==1">Active</span>
                <span v-if="item.status==4">Inactive</span>
              </v-chip>
            </template>
            <template v-slot:item.action="{ item }">
              <v-icon small @click="editItem(item)">edit</v-icon>
            </template>
            <template v-slot:no-data>
              <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template>
          </v-data-table>
        </v-col>
      </v-row>
    </v-container>
    <v-snackbar
      v-model="snackbar"
      :bottom="y === 'bottom'"
      :left="x === 'left'"
      :multi-line="mode === 'multi-line'"
      :right="x === 'right'"
      :timeout="timeout"
      :top="y === 'top'"
      :vertical="mode === 'vertical'"
    >
      {{ text }}
      <v-btn color="pink" flat @click="snackbar = false">Close</v-btn>
    </v-snackbar>
  </v-content>
</template>

<script>
import EditAgent from './EditAgent'
export default {
  components:
  {
    EditAgent
  },
  data: () => ({
    tab: null,
    absolute: true,
    loading: false,
    snackbar: false,
    y: "top",
    x: null,
    mode: "",
    timeout: 6000,
    text: "Hello, I'm a snackbar",
    edit: true,
    dialog: false,
    dataUser: [],
    userType: [],
    headers: [
      { text: "ID", align: "left", value: "id" },
      {
        text: "Name",
        value: "name"
      },
      { text: "Email", value: "email" },
      { text: "Type", value: "userType" },
      { text: "Status", value: "status" },
      { text: "Action", value: "action" }
    ],
    emailRules: [
      v => !!v || "E-mail is required",
      v => /.+@.+/.test(v) || "E-mail must be valid"
    ],
    usernameRules: [
      v => !!v || "Name is required",
      v => (v || "").indexOf(" ") < 0 || "No spaces are allowed"
    ],
    passwordRules: [
      v => (v || "").length >= 8 || `A minimum of 8 characters is allowed`
    ],
    editedIndex: -1,
    editedItem: {
      name: "",
      email: "",
      username: "",
      userType: "",
      role: "",
      contact: ""
    },
    defaultItem: {
      name: "",
      email: "",
      username: "",
      userType: "",
      role: "",
      contact: ""
    }
  }),
  props: {
    source: String
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New User" : "Edit User";
    }
  },
  watch: {},
  created() {
    this.initialize();
  },
  methods: {
    editChange()
    {
      this.dialog=false
    },
    async initialize() {
      try {
        let { data } = await axios({
          method: "get",
          url: "/app/completeuser"
        });
        this.dataUser = data;
      } catch (e) {}
    },
    editItem(item) {
      this.edit = false;
      this.editedIndex = this.dataUser.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.editedItem.password = Math.random()
        .toString(36)
        .slice(-10);
      this.dialog = true;
    },
    deleteItem(item) {
      const index = this.dataUser.indexOf(item);
      confirm("Are you sure you want to delete this item?") &&
        this.dataUser.splice(index, 1);
    },
    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },
    async save() {
      if (this.editedIndex > -1) {
        try {
          let { data } = await axios({
            method: "post",
            url: "/app/updatepassword",
            data: this.editedItem
          });
          this.dataUser[this.editedIndex].status = 3;
          this.close();
        } catch (e) {}
      } else {
        try {
          let { data } = await axios({
            method: "post",
            url: "/app/user",
            data: this.editedItem
          });
          this.dataUser.unshift(this.editedItem);
          this.close();
        } catch (e) {}
      }
    }
  }
};
</script>