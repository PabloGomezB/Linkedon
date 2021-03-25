<template>
    <div class="container">
        <Chart/>
    </div>
</template>

<script>
import Chart from "./Chart.vue";

export default {
    name: "ChartOfertas",
    components: { Chart },
    // data: () => ({
    // loaded: false,
    // chartdata: null,
    // }),
    // mounted() {
    //     this.axios
    //         .get(
    //             "https://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta"
    //         )
    //         .then((response) => {
    //             console.log("ofertas lista chart", response);

    //             this.chartdata = response.data.record;
    //             this.loaded = true;
    //         });
    // },
};
</script>

<style></style>
