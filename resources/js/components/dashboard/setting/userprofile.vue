<template>
    <v-content >
        <v-container fluid>

    <v-row justify="center">

      <v-col sm="12" md="6" lg="6" >

                    <v-row >
                      <v-col lg="12" >
                        <v-card >
                           <div >
                            <v-alert t color="blue darken-3" dark>
                                Update profile
                            </v-alert>
                           </div>
                              <v-card-title  > 
                                <span class="title font-weight-light" dark>User Profile</span>
                              </v-card-title>
                              <v-card-text>
                                <v-row>
                                  <v-col sm="12" md="12" lg="4" >
							                      <v-text-field
							                        v-model="dataList.id"
							                        label="ID"
							                        required
                                                    disabled
							                        filled                                            
							                      ></v-text-field>
						                      </v-col>
                    
                        
                                  <v-col sm="12" md="12" lg="4" >
							                    <v-text-field
                                    v-model="dataList.name"
							                      label="Name"
							                      required
							                      filled
							                    ></v-text-field>
						                      </v-col>
                                     
                                  <v-col sm="12" md="12" lg="4" >
							                    <v-text-field
                                    v-model="dataList.email"
							                      label="Email Address"
							                      required
                                                disabled
							                      filled                                           
							                    ></v-text-field>
						                      </v-col>
                                </v-row>

                                <v-row>
                                  <v-col sm="12" md="12" lg="6" >
							                    <v-text-field
							                      v-model="dataList.userType"
							                      label="User type"
							                      required
                                                disabled
							                      filled                              
							                    ></v-text-field>
						                      </v-col>
                                            
                                  <v-col sm="12" md="12" lg="6" >
                                  <v-text-field
                                      v-model="dataList.role"
                                      label="Role"
                                      required
                                      disabled
                                      filled                                      
                                  ></v-text-field>
						                      </v-col>
                                </v-row>
                        
                                <v-divider></v-divider>
                                <v-row align="center">
                                    
                                  <div class="ml-5" >
                                    <v-btn dark color="blue darken-3" @click="editProfile()">Update Profile</v-btn>
                                    <v-btn dark color="blue darken-3" @click="changePassword()">Change Password</v-btn>
                                  </div>                    
                                   
                                </v-row>
                    
                              </v-card-text>
                            </v-card>
                      </v-col>
                    </v-row>    
      </v-col>
    

      
        <v-col sm="12" md="4" lg="4" >         
        <v-card max-width="344" class="mx-auto"
  >  
  <v-list-item>   
      <v-list-item-content>
        <v-list-item-title class="headline">
          <v-card-text>
              <v-col sm="12" md="12" lg="8" >
              
                <span class="title font-weight-light" dark >{{ dataList.name }}</span>
							            
              </v-col>
              </v-card-text>
            
        </v-list-item-title>
        <v-list-item-subtitle>

        </v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>

    <v-img
      src="data:image/png;base64,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"
      height="194"
    ></v-img>

    <v-card-text>
      <v-col sm="12" md="12" lg="12" >
        <span class="title font-weight-light" dark >{{ dataList.email }}</span>
							            
						            </v-col>
      
    </v-card-text>

    
  </v-card>
  
        </v-col>
        </v-row>
      


 <v-dialog v-model="dialog" persistent max-width="600px">
      
      <v-card>
        <v-card-title>
          <span class="headline">User Profile</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                      <v-text-field
							                 v-model="password.oldPassword"
							                label="Current Password*"
                             :rules="passwordRules"  
							                required                                  
							        ></v-text-field>
                </v-col>
              <v-col cols="12" sm="6" md="4">
                    <v-text-field
							                 v-model="password.newPassword"
							                label="New Password*"
                              :rules="passwordRules"  
							                required                                  
							        ></v-text-field>
              </v-col>
                
              <v-col cols="12" sm="6" md="4">
                <v-text-field
							                 v-model="password.confirmPassword"
							               
                                 :rules="[
                                         v => v == password.newPassword || 'Should be same as new password']"  
                                  label="Confirm Password*"
                                 
													        required             
							                    filled                
							  ></v-text-field>
              </v-col>
                
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <div class="flex-grow-1"></div>
          <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
          <v-btn color="blue darken-1" text @click="save ">Save</v-btn>
          
        </v-card-actions>
      </v-card>
    </v-dialog>



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


</v-container>
</v-content > 
</template>

<script>
  export default 
  {	
	  data: () => ({
        absolute: true,
		    loading:false,
        snackbar: false,
        y: "top",
        x: null,
        mode: "",
        timeout: 6000,
        text: "Hello, I'm a snackbar",
        edit: false,
        dialog: false,
        dataUser: [],
        dataList:{},  
        password:{
          oldPassword:'',
          newPassword:'',
          confirmPassword:'',
        }, 
         passwordRules: [
           
          v => (v || "" ).length>=8|| `Minimum Password charecter is 8`,
          
    ],
         confirmPasswordRules: [
           
          v => (v || "" ).length>=8|| `Minimum Password charecter is 8`,
          v => v == password.newPassword || 'Should be same as new password',
          
    ],
    
    }),
  watch: {},
	created() {
    console.log(this.dataList)
		this.initialize();
  },
  methods: {
    async editProfile(){
      try {
        let { data } = await axios
        ({
				  	method: "post",
            url: "/app/updateUser",
						data: this.dataList
				});
				this.snacks('Successfully Done','green')
				this.close();
      } 
      catch (e) 
      {
					this.loading = false;
					this.snacks('Operation Failed','red')

			}
    },
  async changePassword(){
    this.dialog=true;
  },
    async save() {	
      console.log(this.password.oldPassword)
      console.log(this.password.newPassword)
      console.log(this.password.confirmPassword)
				try {
					let { data } = await axios({
						method: "post",
						url: "/app/changepassword" ,
            data: this.password
            
          });
         
                    if(data==1)
                    {
    					this.snacks('Successfully Done','Green')
                    }
                    else
                    {
                        this.snacks('Operation Failed','red')
                    }
					this.close();
				} catch (e) {
					this.loading = false;
					this.snacks('Operation Failed','red')
				}
 },
		async initialize() {
			this.start();
			try {
        let { data } = await axios
        ({
					method: "get",
					url: "/app/profile/"
				});
				this.dataList = data;
      } 
      catch (e) 
      {
				this.fail();
			}
			this.finish();
    },
        
  },
  close() {
			this.dialog = false;
			this.loading = false;
			setTimeout(() => {
				this.editedItem = Object.assign({}, this.defaultItem);
				this.editedIndex = -1;
			}, 300);
		},
    

};
</script>

<style>

</style>