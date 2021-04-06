<template>
    <div>
        <h1>Gráfico de ofertas por ciudades</h1>

        <ChartBar
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
import ChartBar from "./ChartBar.vue";

export default {
    name: "ChartComarca",
    components: { ChartBar },
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
            let arrayComarcas = new Array();
            this.ofertas.forEach(function(item) {
                arrayComarcas.push(item.ubicacio);
            });
            let uniqueCount = arrayComarcas;
            let ubicacionContadas = {};
            uniqueCount.forEach(function(i) {
                ubicacionContadas[i] = (ubicacionContadas[i] || 0) + 1;
            });
            let arrayLabels = new Array();
            let arrayData = new Array();
            for (let key in ubicacionContadas) {
                arrayLabels.push(key);
                arrayData.push(ubicacionContadas[key]);
            }
            console.log(ubicacionContadas);
            console.log("labels: " + arrayLabels);
            console.log("contador: " + arrayData);
            this.chartdata = {
                labels: arrayLabels,
                datasets: [
                    {
                        label: "Ciudades totales: " + arrayLabels.length,
                        borderWidth: 1,
                        borderColor: [
                            "rgba(255,99,132,1)",
                            "rgba(54, 162, 235, 1)",
                            "rgba(255, 206, 86, 1)",
                            "rgba(75, 192, 192, 1)",
                            "rgba(153, 102, 255, 1)",
                            "rgba (204,209,255,1) ",
                            "rgba (204,0,204,1) ",
                            "rgba (255,102,102,1) ",
                            "rgba (64,64,64,1) ",
                            "rgba (73,0,156,1) ",
                            "rgba (204,102,0,1) ",
                        ],
                        backgroundColor: [
                            "rgba(255, 99, 132, 0.2)",
                            "rgba(54, 162, 235, 0.2)",
                            "rgba(255, 206, 86, 0.2)",
                            "rgba(75, 192, 192, 0.2)",
                            "rgba(153, 102, 255, 0.2)",
                            "rgba (204,209,255,0.2) ",
                            "rgba (204,0,204,0.2) ",
                            "rgba (255,102,102,0.2) ",
                            "rgba (64,64,64,0.2) ",
                            "rgba (73,0,156,0.2) ",
                            "rgba (204,102,0,0.2) ",
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
