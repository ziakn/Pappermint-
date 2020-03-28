<template>
  <v-app >
    <v-content>
      <v-container
        class="fill-height"
        fluid
      >
        <v-row
          align="center"
          justify="center"
        >
          <v-col
            cols="12"
            sm="8"
            md="4"
          >
            <v-card class="elevation-12">
              <v-toolbar
                color="purple darken-4"
                dark
                flat
              >
                <v-toolbar-title>Register form</v-toolbar-title>
                <div class="flex-grow-1"></div>
              </v-toolbar>
              <v-card-text>
                
                  <v-text-field
                    v-model="formValue.name"
                    label="Name"
                    prepend-icon="person"
                    type="text"
                  ></v-text-field>
                <v-text-field
                    v-model="formValue.email"
                    label="Email"
                    :rules="emailRules" 
                    prepend-icon="mail"
                    type="text"
                  ></v-text-field>

                <v-text-field
                    v-model="formValue.contact"
                    label="Mobile"
                    :rules="contactRules"
                    prepend-icon="call"
                    type="text"
                  ></v-text-field>

              </v-card-text>
              <v-card-actions>
                <div class="flex-grow-1"></div>
                <v-btn color="purple darken-4" dark @click="register">Register</v-btn>
              </v-card-actions>
            </v-card>
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
			<v-btn
				color="white"
				text
				@click="snackbar = false"
			>
				Close
      		</v-btn>
    	</v-snackbar>
    </v-content>
  </v-app>
</template>

<script>
  export default {
    props: {
      source: String,
    },
    data: () => ({
      drawer: null,
      formValue:{
          name:'',
          email:'',
          contact:'+974',
      },
      emailRules: [
      v => !!v || "E-mail is required",
      v => /.+@.+/.test(v) || "E-mail must be valid"
    ],
      contactRules: [
      v => !!v || "Mobile is required",
    ],
    }),
    methods:
    {
        async register()
        {
            try {
                this.start();
                let { data } = await axios({
                method: "post",
                url: "/app/staff/user",
                data:this.formValue
            });
            if(data.status==false)
            {
                this.snacks(data.msg,'red')
            }
            this.snacks('Succesfully Registeded','green')
            } catch (e) {
                this.fail();
            }

        }
    }
  }
</script>