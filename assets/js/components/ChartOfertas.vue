<template>
    <div>
        <h1>Gráfico</h1>

        <Chart
            v-if="isOfertasObtenidas && ofertas.length != 0"
            :chart-data="chartdata"
            :options="options"
        />
        <div v-else-if="!isOfertasObtenidas" class="text-center mt-5">
            <b-spinner label="Loading..."></b-spinner>
        </div>
        <div v-else-if="ofertas.length == 0">
            <p>No se han encontrado datos.</p>
        </div>
    </div>
</template>

<script>
import Chart from "./Chart.vue";

export default {
    name: "ChartOfertas",
    components: { Chart },
    props: {
        ofertas: Array,
        isOfertasObtenidas: Boolean,
    },
    data: () => ({
        chartdata: null,
        options: {
            legend: {
                display: true,
            },
            responsive: true,
            maintainAspectRatio: false,
        },
    }),
    methods: {
        estadisticas() {
            let arrayCategorias = new Array();
            this.ofertas.forEach(function(item) {
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
        },
    },
    mounted() {
        this.estadisticas();
    },
    watch: {
        ofertas: function(newVal, oldVal) {
            this.estadisticas();
        },
    },
};
</script>

<style></style>
