<template>
    <card class="flex flex-col items-center justify-center dashboard-map-container">
        <div id="dashboard-map-image-container">
        </div>
    </card>
</template>

<script>
export default {
    props: [
        'card',

        // The following props are only available on resource detail cards...
        // 'resource',
        // 'resourceId',
        // 'resourceName',
    ],

    mounted() {
        //
    },
}
</script>
<style>
/*.dashboard-map-container {*/
/*    height: 35vh;*/
/*}*/

#dashboard-map-image-container {
    width: 100%;
    height: 100%;
    background-image: url("/storage/dashboard-map.png");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}
</style>
