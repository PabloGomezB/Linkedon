<template>
    <div class="container">
        <Chart v-if="loaded" :chartdata="chartdata" :options="options" />
        <div v-else class="text-center mt-5">
            <b-spinner label="Loading..."></b-spinner>
        </div>
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
        options: {
            legend: {
                display: true,
            },
            responsive: true,
            maintainAspectRatio: false,
        },
    }),
    mounted() {
        let arrayCategorias = new Array();
        this.axios
            .get(
                "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta?join=categoria_id,categoria"
            )
            .then((response) => {
                response.data.records.forEach(function(item) {
                    arrayCategorias.push(item.categoria_id.descripcio);
                });
                let uniqueCount = arrayCategorias;
                var categoriasContadas = {};
                uniqueCount.forEach(function(i) {
                    categoriasContadas[i] = (categoriasContadas[i] || 0) + 1;
                });
                let arrayLabels = new Array();
                let arrayData = new Array();
                for (let key in categoriasContadas) {
                    arrayLabels.push(key);
                    arrayData.push(categoriasContadas[key]);
                }
                console.log(categoriasContadas);
                console.log("labels: " + arrayLabels);
                console.log("contador: " + arrayData);
                this.chartdata = {
                    labels: arrayLabels,
                    datasets: [
                        {
                            borderWidth: 1,
                            borderColor: [
                                "rgba(255,99,132,1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                            ],
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.2)",
                                "rgba(54, 162, 235, 0.2)",
                                "rgba(255, 206, 86, 0.2)",
                                "rgba(75, 192, 192, 0.2)",
                                "rgba(153, 102, 255, 0.2)",
                            ],
                            data: arrayData,
                        },
                    ],
                };
                this.loaded = true;
            });
    },
};
</script>

<style></style>
