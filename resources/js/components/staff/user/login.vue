<template>
  <v-app>
    <v-content>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="4" v-show="complete">
            <v-card class="elevation-12" >
              <OverLoading :trigger="isLoading"></OverLoading>
              <v-toolbar color="purple darken-4" dark flat>
                <v-toolbar-title>Login form</v-toolbar-title>
                <div class="flex-grow-1"></div>
              </v-toolbar>
              <v-card-text>

                <v-text-field
                  v-model="formValue.email"
                  label="Email"
                  :rules="emailRules"
                  prepend-icon="mail"
                  type="text"
                  filled
                ></v-text-field>

                <v-text-field
                  v-model="formValue.password"
                  label="Password"
                  :rules="passwordRules"
                  prepend-icon="lock"
                  type="password"
                  filled
                ></v-text-field>
              </v-card-text>
              <v-card-actions>
                <div class="flex-grow-1"></div>
                <v-btn color="purple darken-4" dark @click="login">Login</v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
          <v-col cols="12" sm="8" md="8" v-show="!complete">
            <v-expand-transition >
            <v-card  class="elevation-12" v-show="!isDone">
               <OverLoading :trigger="isLoading"></OverLoading>
              <v-toolbar color="purple darken-4" dark flat >
                <v-toolbar-title >Complete Profile</v-toolbar-title>
                <div class="flex-grow-1"></div>
              </v-toolbar>
              <v-card-text>
                <v-row>
                  <v-col cols="12" sm="12" md="6">
                    <v-text-field
                      v-model="formValue.qid_no"
                      label="QID no"
                      prepend-icon="assignment_ind"
                      type="text"
                      filled
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="12" md="6">
                      <v-text-field
                      v-model="formValue.passport_no"
                      label="Passport no"
                      prepend-icon="menu_book"
                      type="text"
                      filled
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="12" md="12">
                    <v-text-field
                      v-model="formValue.city"
                      label="City"
                      prepend-icon="home_work"
                      type="text"
                      filled
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="12" md="12">
                    <v-textarea
                      v-model="formValue.address"
                      label="Company Address"
                      type="text"
                      prepend-icon="mdi-map"
                      :rules="[v => !!v || 'Company Address is required']"
                      filled
                    ></v-textarea>
                  </v-col>
                  <v-col cols="12" sm="12" md="6">

                    <v-file-input
                      v-model="document"
                      color="blue accent-4"
                      label="QID"
                      placeholder="Select your file"
                      filled
                      :show-size="1000"
                    >
                    </v-file-input>
                  </v-col>
                  <v-col cols="12" sm="12" md="6">
                    <v-file-input
                      v-model="passport"
                      color="blue accent-4"
                      label="Passport"
                      placeholder="Select your file"
                      filled
                      :show-size="1000"
                    >
                      
                    </v-file-input>
                  </v-col>
                  <v-col cols="12" sm="12" md="6">
                    <v-radio-group v-model="formValue.type" row @change="companyList">
                      <v-radio label="Individual" value="individual"></v-radio>
                      <v-radio label="Company" value="company" ></v-radio>
                    </v-radio-group>
                  </v-col>
                  <v-col cols="12" sm="12" md="6" v-show="formValue.type=='company'">
                    <v-autocomplete
                    v-model="formValue.company_id"
                        label="Company"
                        item-text="name"
                        item-value="id"
                        :items="dataCompany"
                        prepend-icon="account_balance"
                        filled
                      >
                        <template v-slot:append-outer>

                            <v-icon @click="isCompany=!isCompany">add_circle</v-icon>
                        </template>
                      </v-autocomplete>
                  </v-col>
                  <Company :trigger="isCompany" @send="newCompany" ></Company>
                </v-row>
                  </v-card-text>

              <v-card-actions >
                <div class="flex-grow-1"></div>
                <v-btn color="purple darken-4" dark @click="completeLogin">Complete</v-btn>
              </v-card-actions>
            </v-card>
              </v-expand-transition>
                           <v-alert
               v-show="isDone"
                color="green"
                border="left"
                elevation="2"
                colored-border
                icon="mdi-check"
              >
                Succesfully completed your profile, please wait for confirmaiton of your provided data, we will mail you after confirmation
              </v-alert>
          </v-col>
        </v-row>
      </v-container>
      <v-snackbar
        v-model="snackbar"
        :vertical="snackvertical"
        :timeout="snacktimeout"
        :top="snacktop"
        :color="snackcolor"
      >
        {{ snacktext }}
        <v-btn color="white" text @click="snackbar = false">Close</v-btn>
      </v-snackbar>
    </v-content>
  </v-app>
</template>

<script>
import Company from './Company'
import OverLoading from './../common/OverLoading'
export default {
  components:
  {
    Company,
    OverLoading
  },
  props: {
    source: String
  },
  data: () => ({
    isDone:false,
    isLoading:false,
    dataCompany:[],
    isCompany:false,    
    complete: true,
    drawer: null,
    document: null,
    passport:null,
    formValue: {
      password: "t2uksi56mn",
      email: "zubaer.haque@gmail.com",
      type:'',
      qid_no:'',
      passport_no:'',
      city:'',
      address:'',
      company_id:''
      
    },
    emailRules: [
      v => !!v || "E-mail is required",
      v => /.+@.+/.test(v) || "E-mail must be valid"
    ],

    passwordRules: [
      v => (v || "").length >= 8 || `A minimum of 8 characters is allowed`
    ]
  }),
  methods: {
    newCompany(data)
    {
      this.dataCompany.unshift(data.status)
      this.formValue.company_id=data.status.id

    },
    async companyList()
    {
      if(this.dataCompany.length || this.formValue.type!="company")
      {
        return
      }
      try {
        let { data } = await axios({
          method: "get",
          url: "/app/company",
        });
        this.dataCompany=data;
      } catch (e) {
        this.snacks("Failed, company loading", "red");
      }
    },
    async login() {
      
      try {
        this.isLoading=true;
        this.start();
        let { data } = await axios({
          method: "post",
          url: "/app/staff/login",
          data: this.formValue
        });
        if (data.token == false) {
          this.snacks(data.msg, "red");
          return;
        }
        console.log(data.access_token);
        this.authUser(data.access_token);
        this.snacks("Succesfully loggedin", "green");
      } catch (e) {
        this.fail();
        this.isLoading=false;
        this.snacks("Failed, try again", "red");
      }
    },
    async authUser(token) {
      
      token = "Bearer " + token;
      console.log(token);
      try {
        let { data } = await axios({
          method: "get",
          url: "/app/auth",
          headers: {
            Authorization: token
          }
        });
        console.log(data);
        data.token = token;
        this.$store.commit("user", data);
        this.isLoading=false;
        
        if (data.status == 3) {
          this.complete = false;
        } 
        else if(data.status == 4)  {
          this.complete = false;
          this.isDone = true;
        }
        else {
          this.$router.push("/staff");
        }
      } catch (e) {
        this.fail();
        this.snacks("Failed, try again", "red");
        this.isLoading=false;
      }
    },
    async completeLogin() {
       this.isLoading=true;
        const formData = new FormData();
            formData.append("document", this.document);
            formData.append("passport", this.passport);
        for ( var key in this.formValue ) {
            formData.append(key, this.formValue[key]);
        }
      try {
        let { data } = await axios({
          method: "post",
          url: "/app/staff/complete",
          data: formData,
          headers: {
            Authorization: this.$store.state.token
          }
        });
        this.snacks("Successfully Updated", "green");
         this.isLoading=false;
         this.isDone=true;
         
      } catch (e) {
        this.fail();
        this.snacks("Failed, try again", "red");
         this.isLoading=false;
      }
    }
  }
};
</script>