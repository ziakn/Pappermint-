<template>
<v-content>
		<v-container fluid>
			<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11" >
          <v-toolbar flat color="white">
            <v-toolbar-title>User List</v-toolbar-title>
            <v-divider class="mx-2" inset vertical></v-divider>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on }">
                <v-btn color="primary" dark class="mb-2" v-on="on" @click="edit=true">New User</v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container grid-list-md>
                    <v-layout wrap>
                      <v-flex xs12 sm12 md12>
                        <v-text-field
                          v-model="editedItem.name"
                          label="Full Name"
                          :rules="[v => !!v || 'User type is required']"
                          required
                          filled
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm12 md12>
                        <v-text-field 
                        :rules="emailRules" 
                        v-model="editedItem.email" 
                        label="Email"
                        filled
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm12 md12>
                        <v-text-field 
                        :rules="emailRules" 
                        v-model="editedItem.contact"
                        label="Mobile"
                        type="text"
                        filled
                        ></v-text-field>
                      </v-flex>

                      <v-flex xs12 sm12s md12 v-if="edit">
                        <v-text-field
                          v-model="editedItem.password"
                          :rules="passwordRules"
                          label="Password"
                          type="password"
                          filled
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm12 md12>
                        <v-select
                          v-model="editedItem.user_type_id"
                          :items="userType"
                          item-text="name"
                          item-value="id"
                          :rules="[v => !!v || 'User type is required']"
                          label="User Type"
                          required
                          filled
                        ></v-select>
                      </v-flex>
                      <v-flex xs12 sm12 md12>
                        <v-text-field
                          v-model="editedItem.role"
                          label="Role"
                          :rules="[v => !!v || 'Role is required']"
                          required
                          filled
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                  </v-container>
              </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="red darken-1" text @click="close">Cancel</v-btn>
                  <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>
          <v-data-table :headers="headers" :items="dataUser" class="elevation-1">
              <template v-slot:item.action="{ item }">
                <v-icon small @click="editItem(item)">edit</v-icon>
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
export default {
  data: () => ({
    absolute: true,
		loading:false,
    snackbar: false,
    y: "top",
    x: null,
    mode: "",
    timeout: 6000,
    text: "Hello, I'm a snackbar",
    edit: true,
    dialog: false,
    dataUser: [],
    userType: [
      
    ],
    headers: [
      { text: "ID", align: "left", value: "id" },
      {
        text: "Name",
        value: "name"
      },
      { text: "Email", value: "email" },
      { text: "Type", value: "userType" },
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
      role:"",
      contact:""

    },
    defaultItem: {
      name: "",
      email: "",
      username: "",
      userType: "",
      role:"",
      contact:""
    }
  }),
  props: {
    source: String
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    }
  },
  watch: {},
  created() {
    this.initialize();
  },
  methods: {
    async initialize() {
      try {
        let { data } = await axios({
          method: "get",
          url: "/app/user"
        });
        this.dataUser = data;
      } catch (e) {}
            try {
        let { data } = await axios({
          method: "get",
          url: "/app/usertype"
        });
        this.userType = data;
      } catch (e) {}
    },
    editItem(item) {
      this.edit = false;
      this.editedIndex = this.dataUser.indexOf(item);
      this.editedItem = Object.assign({}, item);
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
            url: "/app/updateUser",
            data: this.editedItem
          });
          console.log(data);
          Object.assign(this.dataUser[this.editedIndex], this.editedItem);
          this.close();
        } catch (e) {
        }
      } else {
        try {
          let { data } = await axios({
            method: "post",
            url: "/app/user",
            data: this.editedItem
          });
          this.dataUser.unshift(this.editedItem);
          this.close();
        } catch (e) {

        }
      }
    }
  }
};
</script>