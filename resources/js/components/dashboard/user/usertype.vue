<template>
	<v-content>
		<v-container fluid>
			<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="10" >
					<v-row>
						<v-col cols="12" lg="6" offset="6">
							<v-text-field
								v-model="search"
								append-icon="search"
								label="Search"
								single-line
								hide-details
								filled
							></v-text-field>
						</v-col>
					</v-row>
					<v-toolbar flat color="white">
						<v-toolbar-title>User Type List</v-toolbar-title>
						<v-divider class="mx-2" inset vertical></v-divider>
						<v-spacer></v-spacer>

						<v-dialog v-model="dialog" max-width="500px">
							<v-card>
								<v-card-title>
									<span class="subtitle-1">{{ formTitle }}</span>
								</v-card-title>
								<v-card-text>
									<v-container grid-list-md>
										<v-layout wrap>	
											<v-flex xs12 sm12 md12>
												<v-text-field
													v-model="editedItem.name"
													label="User Type"
													:rules="[v => !!v || 'User type is required']"
													required
													filled
												></v-text-field>
											</v-flex>
											<v-flex xs12 sm12 md12>
                                                <v-combobox
                                                    v-model="editedItem.pages"
                                                    :items="dataPages"
                                                    label="Permissions on Pages"
                                                    multiple
                                                    item-text="name"
                                                    return-object
                                                    chips
                                                    filled
                                                ></v-combobox>
											</v-flex>

										</v-layout>
									</v-container>
								</v-card-text>
								<v-card-actions>
									<v-spacer></v-spacer>
									<v-btn text color="error" @click="close">Cancel</v-btn>
									<v-btn  :loading="loading" :disabled="loading" text color="primary" @click="save">Save</v-btn>
								</v-card-actions>
							</v-card>
						</v-dialog>
					</v-toolbar>
					<v-data-table :headers="headers" :items="dataList" :search="search" class="elevation-1">

						<template v-slot:item.action="{ item }">
							<v-icon small @click="editItem(item)">edit</v-icon>
							<v-icon small @click="deleteItem(item)">delete</v-icon>
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
		<DeleteModal :trigger="isDelete" :title="deleteTitle" :body="deleteBody" @request="remove"></DeleteModal>
		<v-btn bottom color="blue darken-3" dark fab fixed right @click="dialog = !dialog">
			<v-icon>mdi-plus</v-icon>
		</v-btn>
	</v-content>
</template>

<script>
import DeleteModal from "./../common/DeleteModal";
export default {
	components: {
		DeleteModal
	},
	data: () => ({
		absolute: true,
		loading:false,
		search: "",
		dataIndex: null,
		deleteTitle: "",
		deleteBody: "",
		isDelete: false,
		edit: true,
		dialog: false,
		filterValue:
		{

        },
        dataPages:[],
		snackBar: {
			text: "",
			color: "red",
			trigger: false
		},
		dataList: [],
		headers: [
			{ text: "ID", value: "id" },
			{ text: "User Type", value: "name" },
			{ text: "Action", align: "center", value: "action", sortable: false }
		],

		editedIndex: -1,
		editedItem: {
			name: "",
			pages: []
		},
		defaultItem: {
            name: "",
			pages: []

        }
	}),

	computed: {
		formTitle() {
			return this.editedIndex === -1 ? "New UserType" : "Edit UserType";
		}
	},
	watch: {},
	created() {
		this.initialize();
	},
	methods: {

		async initialize() {
			this.start();
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/usertype"
				});

				this.dataList = data;
			} catch (e) {
				this.fail();
            }
            try {
				let { data } = await axios({
					method: "get",
					url: "/app/dashboardpage"
				});
				this.dataPages = data;
			} catch (e) {
				this.fail();
			}

			this.finish();
		},
		editItem(item) {
			this.edit = false;
			this.editedIndex = this.dataList.indexOf(item);
			this.editedItem.name = item.name;
			this.editedItem.pages = item.pages;
			this.dialog = true;
		},
		deleteItem(item) {
			this.dataIndex = this.dataList.indexOf(item);
			this.deleteTitle = "Are you sure you want to delete this item?";
			this.isDelete = !this.isDelete;
		},
		close() {
			this.dialog = false;
			this.loading = false;
			setTimeout(() => {
				this.editedItem = Object.assign({}, this.defaultItem);
				this.editedIndex = -1;
			}, 300);
		},
		async save() {
			if(this.editedItem.name=='')
			{
				return

			}
			
			this.loading=true;
			if (this.editedIndex > -1) {
				try {
					let { data } = await axios({
						method: "put",
						url: "/app/usertype/" + this.dataList[this.editedIndex].id,
						data: this.editedItem
					});
					console.log(data);
					this.snacks('Successfully Done','Green')

					Object.assign(this.dataList[this.editedIndex], this.editedItem);
					this.close();
				} catch (e) {
					this.loading = false;
					this.snacks('Operation Failed','Red')
				
				}
			} else {
				try {
					let { data } = await axios({
						method: "post",
						url: "/app/usertype",
						data: this.editedItem
					});
					this.snacks('Successfully Done','Green')
					this.dataList.unshift(data.status);
					this.close();
				} catch (e) {
					this.loading = false;
					this.snacks('Operation Failed','Red')

				}
			}
		},
		async remove() {
			try {
				let { data } = await axios({
					method: "delete",
					url: "/app/usertype/" + this.dataList[this.dataIndex].id
				});
				this.snacks('Successfully Done','Green')
				this.dataList.splice(this.dataIndex, 1);
				this.close();
			} catch (e) {
				this.snacks('Operation Failed','Red')

			}
		}
	}
};
</script>