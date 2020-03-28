<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="800px">
      <v-card>
        <v-card-title>
          <span class="headline">New Company</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field v-model="formValue.name" label="Legal name*" filled required></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field v-model="formValue.reg_no" label="Registration No" filled></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-menu
                  v-model="data1"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="formValue.reg_expire_date"
                      label="Expire Date"
                      prepend-icon="event"
                      readonly
                      v-on="on"
					  filled
                    ></v-text-field>
                  </template>
                  <v-date-picker v-model="formValue.reg_expire_date" @input="data1 = false" filled></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="6">
                <v-text-field v-model="formValue.municipality_no" label="Municipality No" filled></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-menu
                  v-model="data2"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="formValue.mun_expire_date"
                      label="Expire Date"
                      prepend-icon="event"
                      readonly
                      v-on="on"
					  filled
                    ></v-text-field>
                  </template>
                  <v-date-picker v-model="formValue.mun_expire_date" @input="data2 = false" filled></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="6">
                <v-text-field v-model="formValue.computer_card_no" label="Computer Card No" filled></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field v-model="formValue.contact" label="Contact Number" filled></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field v-model="formValue.email" label="Email" filled></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field v-model="formValue.website" label="Website" filled></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field  v-model="formValue.bank" label="Bank Info" messages="Optional"  filled></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field v-model="formValue.location" label="Location" filled></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-textarea label="Address" v-model="formValue.address" filled></v-textarea>
              </v-col>
              <v-col cols="6">
                <v-textarea label="Comment" v-model="formValue.comment" filled></v-textarea>
              </v-col>

              <v-col cols="6">
                <v-file-input
                  v-model="cr_copy"
                  color="purple accent-4"
                  label="CR"
                  placeholder="Select your file"
                  prepend-icon="mdi-paperclip"
                  filled
                  :show-size="1000"
                >
                  <template v-slot:selection="{ index, text }">
                    <v-chip v-if="index < 2" color="purple accent-4" dark label small>{{ text }}</v-chip>

                    <span
                      v-else-if="index === 2"
                      class="overline grey--text text--darken-3 mx-2"
                    >+{{ files.length - 2 }} File(s)</span>
                  </template>
                </v-file-input>
              </v-col>

				<v-col cols="6">
                <v-file-input
                  v-model="municipality_copy"
                  color="purple accent-4"
                  label="Municipality"
                  placeholder="Select your file"
                  prepend-icon="mdi-paperclip"
                  filled
                  :show-size="1000"
                >
                  <template v-slot:selection="{ index, text }">
                    <v-chip v-if="index < 2" color="purple accent-4" dark label small>{{ text }}</v-chip>

                    <span
                      v-else-if="index === 2"
                      class="overline grey--text text--darken-3 mx-2"
                    >+{{ files.length - 2 }} File(s)</span>
                  </template>
                </v-file-input>
              </v-col>
			<v-col cols="6">
                <v-file-input
                  v-model="computer_card_copy"
                  color="purple accent-4"
                  label="Computer card"
                  placeholder="Select your file"
                  prepend-icon="mdi-paperclip"
                  filled
                  :show-size="1000"
                >
                  <template v-slot:selection="{ index, text }">
                    <v-chip v-if="index < 2" color="purple accent-4" dark label small>{{ text }}</v-chip>

                    <span
                      v-else-if="index === 2"
                      class="overline grey--text text--darken-3 mx-2"
                    >+{{ files.length - 2 }} File(s)</span>
                  </template>
                </v-file-input>
              </v-col>
			<v-col cols="6">
                <v-file-input
                  v-model="id_copy"
                  color="purple accent-4"
                  label="ID card"
                  placeholder="Select your file"
                  prepend-icon="mdi-paperclip"
                  filled
                  :show-size="1000"
                >
                  <template v-slot:selection="{ index, text }">
                    <v-chip v-if="index < 2" color="purple accent-4" dark label small>{{ text }}</v-chip>

                    <span
                      v-else-if="index === 2"
                      class="overline grey--text text--darken-3 mx-2"
                    >+{{ files.length - 2 }} File(s)</span>
                  </template>
                </v-file-input>
              </v-col>
              <v-row v-for="(partner,index) in partners" :key="index">
              <v-col cols="6">
                <v-text-field  v-model="partner.name" label="Partner Name" messages="Optional"  filled></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field v-model="partner.id" label="Partner ID" filled></v-text-field>
              </v-col>
              </v-row>
              <v-col cols="6">
                <v-btn color="purple darken-3" dark @click="addPartner">Add Partner</v-btn>
              </v-col>
            </v-row>
          </v-container>
                  </v-card-text>
        <v-card-actions>
          <div class="flex-grow-1"></div>
          <v-btn text @click="dialog = false">Close</v-btn>
          <v-btn color="purple darken-1" text :loading="loading" :disabled="loading"  @click="save">Save</v-btn>
        </v-card-actions>
      </v-card>
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
    </v-dialog>
  </v-row>
</template>

<script>
export default {
  data: () => ({
  	loading:false,
    dialog: false,
    data1: false,
    data2: false,
    cr_copy: null,
    municipality_copy:null,
    id_copy:null,
    computer_card_copy:null,
    defaultPartner:
    {
      id:'',
      name:''
    },
    partners:[],
      formValue: {
      },
  }),
  props: {
    trigger: false
  },
  methods:
  {
    addPartner()
    {
      this.partners.push({
        id:'',
        name:''
      });
    },
	  async save()
	  {
		  this.loading=true;
      const formData = new FormData();
      this.partners.forEach(file => {
      formData.append("partners[]", JSON.stringify(file));
      });
      formData.append("cr_copy", this.cr_copy);
      formData.append("municipality_copy", this.municipality_copy);
      formData.append("id_copy", this.id_copy);
      formData.append("computer_card_copy", this.computer_card_copy);
			for ( var key in this.formValue ) {
				formData.append(key, this.formValue[key]);
			}
			try {
				let { data } = await axios({
				method: "post",
				url: "/app/company",
				data: formData,
				headers: {
					Authorization: this.$store.state.token
				}
				});
				this.snacks("Successfully Added", "green");
        this.loading=false;
        this.$emit('send',data);
        this.dialog=false;
			} catch (e) {
				this.fail();
				this.snacks("Failed, try again", "red");
				this.loading=false;
			}
	  }

  },
  watch: {
    trigger() {
      this.dialog = true;
    }
  }
};
</script>

<style>
</style>