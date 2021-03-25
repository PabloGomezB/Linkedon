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
    data: () => ({
    loaded: false,
    chartdata: null,
    }),
    mounted() {
        this.axios
            .get(
                "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta?join=categoria_id,categoria"
            )
            .then((response) => {
                // console.log("ofertas lista chart", response);
                response.data.records.forEach(function(item){
                    console.log("categoria: " + item.categoria_id.descripcio);
                })

                // this.chartdata = response.data.record;
                // this.loaded = true;
            });
    },
};
</script>

<style></style>
