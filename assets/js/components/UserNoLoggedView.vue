<template>
    <div>
        <div class="mb-5">
            <ListaOfertas
                :isOfertasObtenidas="isOfertasObtenidas"
                :ofertas="resultadoOfertas"
            ></ListaOfertas>
        </div>
        <hr style="background-color:#ededed;margin-bottom:50px;width:80%">
        <div class="row">
            <div class="col-md-6">
                <ChartOfertas
                    :isOfertasObtenidas="isOfertasObtenidas"
                    :ofertas="resultadoOfertas"
                ></ChartOfertas>
            </div>

            <div class="col-md-6">
                <ChartComarca
                    :isOfertasObtenidas="isOfertasObtenidas"
                    :ofertas="resultadoOfertas"
                ></ChartComarca>
            </div>
        </div>
    </div>
</template>

<script>
import ChartOfertas from "./ChartOfertas";
import ChartComarca from "./ChartComarca";
import ListaOfertas from "./ListaOfertas";

export default {
    name: "UserNoLoggedView",
    components: {
        ChartOfertas,
        ChartComarca,
        ListaOfertas,
    },
    data() {
        return {
            resultadoOfertas: new Array(),
            isOfertasObtenidas: false,
        };
    },
    methods: {
        getOfertas() {
            this.isOfertasObtenidas = false;
            this.axios
                .get(
                    "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta?join=categoria_id,categoria"
                )
                .then((response) => {
                    console.log("lista ofertas", response);
                    this.resultadoOfertas = response.data.records;
                    this.isOfertasObtenidas = true;
                });
        },
    },
    created() {
        this.getOfertas();
    },
};
</script>

<style></style>
