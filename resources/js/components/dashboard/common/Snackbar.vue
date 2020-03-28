<template>
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
</template>

<script>
export default {
    data(){
		return {


		}
	},
    props:
    {
       
    },
    watch:
    {
        
    }

}
</script>

<style>

</style>