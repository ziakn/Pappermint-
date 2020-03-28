<template>
  <v-card>
	  <OverLoading :trigger="isLoading"></OverLoading>
    <v-card-title>
      <span class="headline">Edit Agent</span>
    </v-card-title>

    <v-card-text>
      <v-container grid-list-md>
        <v-tabs v-model="tab" centered grow>
          <v-tabs-slider></v-tabs-slider>
          <v-tab href="#tab-1">Basic Information</v-tab>

          <v-tab href="#tab-2">Advance Information</v-tab>
        </v-tabs>
        <v-tabs-items v-model="tab">
          <v-tab-item value="tab-1">
            <v-layout wrap ma-6>
              <v-flex xs12 sm12s md12>
                <v-text-field v-model="editedItem.name" label="Name" type="text" filled ></v-text-field>
              </v-flex>
              <v-flex xs12 sm12s md12>
                <v-text-field v-model="editedItem.email" label="email" type="text" filled disabled></v-text-field>
              </v-flex>
              <v-flex xs12 sm12s md12>
                <v-text-field v-model="editedItem.contact" label="mobile" type="text" filled disabled></v-text-field>
              </v-flex>
            </v-layout>
          </v-tab-item>
          <v-tab-item value="tab-2">
			<v-layout wrap ma-6>
				<v-col cols="12" sm="12" md="6">
				<v-text-field
					v-model="editedItem.info.qid_no"
					label="QID no"
					prepend-icon="assignment_ind"
					type="text"
					filled
				></v-text-field>
				</v-col>
				<v-col cols="12" sm="12" md="6">
				<v-text-field
					v-model="editedItem.info.passport_no"
					label="Passport no"
					prepend-icon="menu_book"
					type="text"
					filled
				></v-text-field>
				</v-col>
				<v-col cols="12" sm="12" md="12">
				<v-text-field
					v-model="editedItem.info.city"
					label="City"
					prepend-icon="home_work"
					type="text"
					filled
				></v-text-field>
				</v-col>
				<v-col cols="12" sm="12" md="12">
				<v-textarea
					v-model="editedItem.info.address"
					label="Company Address"
					type="text"
					prepend-icon="mdi-map"
					:rules="[v => !!v || 'Company Address is required']"
					filled
				></v-textarea>
				</v-col>
				<v-col cols="12" sm="12" md="8" >
					<v-file-input
						v-model="document"
						color="blue accent-4"
						label="QID"
						:placeholder="editedItem.info.document_copy?'Update QID':'Add QID'"
						filled
						:show-size="1000"
					>

					</v-file-input>
				</v-col>
				<v-col cols="12" sm="12" md="4"  @click="viewDoc(editedItem.info.document_copy)" v-show="editedItem.info.document_copy">
					<v-btn color="primary" block  large>View ID</v-btn>
				</v-col>
				<v-col cols="12" sm="12" md="8" >
				<v-file-input
					v-model="passport"
					color="blue accent-4"
					label="Passport"
					:placeholder="editedItem.info.passport_copy?'Update Passport':'Add Passport'"
					filled
					:show-size="1000"
				>
				</v-file-input>
				</v-col>
				<v-col cols="12" sm="12" md="4" v-show="editedItem.info.passport_copy">
					<v-btn color="primary" block @click="viewDoc(editedItem.info.passport_copy)" large>View Passport</v-btn>
				</v-col>
				<v-col cols="12" sm="12" md="6">
				<v-radio-group v-model="editedItem.info.type" row>
					<v-radio label="Individual" value="individual"></v-radio>
					<v-radio label="Company" value="company"></v-radio>
				</v-radio-group>
				</v-col>
				<v-col cols="12" sm="12" md="6" v-show="editedItem.info.type=='company'">
				<v-autocomplete
					v-model="editedItem.info.company_id"
					label="Company"
					item-text="name"
					item-value="id"
					:items="dataCompany"
					prepend-icon="account_balance"
					filled
				>
					
				</v-autocomplete>
				</v-col>
			</v-layout>
          </v-tab-item>
        </v-tabs-items>
      </v-container>
    </v-card-text>
	<PDF :trigger="isPDF" :pdf="docData"></PDF>
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
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="red darken-1" text @click="close">Cancel</v-btn>
      <v-btn color="blue darken-1" text @click="save">Save</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>

import PDF from './../common/PDF'
import OverLoading from './../common/OverLoading'
export default {
	components: {
	PDF,
	OverLoading
  },
	data: () => ({
		isLoading:false,
		docData:'',
		isPDF:false,
		dataCompany:[],
		document: null,
		passport:null,
		tab: null,
		dialog: false
  }),
  props: {
    editedItem: {}
  },
  methods: {
    close() {
      this.$emit("dialog", this.dialog);
    },
	async save() 
	{
		this.isLoading=true;
		const formData = new FormData();
		formData.append("document", this.document);
		formData.append("passport", this.passport);
		formData.append("infos", JSON.stringify(this.editedItem.info));
		for ( var key in this.editedItem ) {
			formData.append(key, this.editedItem[key]);
		}
		try {
			let { data } = await axios({
			method: "post",
			url: "/app/staff/updateagent",
			data: formData
			});
			if(data==1)
			this.snacks("Success, Data Updated", "green");
			else
			this.snacks("Failed, company loading", "red");
			this.isLoading=false;
		}
		catch (e)
		{
			this.snacks("Failed, company loading", "red");
			this.isLoading=false;
		}

	},
	async getCompany()
	{
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
	viewDoc(data)
	{
		this.isPDF=!this.isPDF;
		this.docData=data;

	}
  },
  created()
  {
	  this.getCompany();
  }
};
</script>

<style>
</style>