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
            Getting your files
        </v-col>
        <v-col cols="8">
            <v-progress-linear
            color="deep-purple accent-4"
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