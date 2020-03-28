<template>
    <v-overlay
    :absolute="absolute"
    :opacity="opacity"
    :value="trigger"
    >
        <v-row
        class="fill-height"
        align-content="center"
        justify="center"
        >
        <v-col
            class="subtitle-1 text-center"
            cols="12"
        >
            {{message}}
        </v-col>
        <v-col cols="8">
            <v-progress-linear
            color="blue accent-4"
            indeterminate
            rounded
            height="10"
            ></v-progress-linear>
        </v-col>
        </v-row>
    </v-overlay>
</template>

<script>
export default {
    props:
    {
        trigger:false,
        message:String,

    },
 data: () => ({
        overlay: false,
        absolute: true,
        opacity: 1,
     }),
}
</script>

<style>

</style>