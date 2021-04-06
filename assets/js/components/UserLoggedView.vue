<template>
    <div>
        <div class="mb-5">
            <OfertasByCategorias
                v-if="hasUser"
                :ofertas="ofertas"
                :isOfertasObtenidas="isOfertasObtenidas"
                @getOfertasEvent="getOfertas()"
                :userLogged="userLogged"
            ></OfertasByCategorias>
            <div v-else class="text-center mt-5">
                <b-spinner label="Loading..."></b-spinner>
            </div>
        </div>
        <div v-if="showChart">
            <ChartOfertas
                :isOfertasObtenidas="isOfertasObtenidas"
                :ofertas="ofertas"
            ></ChartOfertas>
        </div>
    </div>
</template>

<script>
// import ListaOfertas from "./ListaOfertas";
import OfertasByCategorias from "./OfertasByCategorias";
import ChartOfertas from "./ChartOfertas";
import * as moment from "moment/moment";
import bus from "../busEvent";

export default {
    name: "UserLoggedView",
    components: {
        OfertasByCategorias,
        ChartOfertas,
    },
    data() {
        return {
            ofertas: [],
            isOfertasObtenidas: false,
            userLogged: {},
            hasUser: false,
            showChart: true,
        };
    },
    methods: {
        getOfertas() {
            this.isOfertasObtenidas = false;

            this.axios
                .get(
                    "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta?filter=estat,eq,1&join=empresa_id,empresa&join=categoria_id,categoria&order=data_publicacio,asc&filter=data_publicacio,gt," +
                        this.getDate3MonthsSubstracted()
                )
                .then((response) => {
                    console.log("user logged view", response);
                    this.ofertas = response.data.records;
                    this.isOfertasObtenidas = true;
                });
        },
        getDate3MonthsSubstracted() {
            //Metodo para obtener la fecha de hace 3 meses.
            return moment()
                .subtract(3, "months")
                .format("YYYY/MM/DD");
        },
        getUserLogged() {
            //Obtener el usuario logged
            this.axios.get("/api/getUserLogged").then((response) => {
                console.log("userLogged", response.data);
                //Guardar los datos del usuario logged
                this.userLogged = response.data;
                //Activa el v-if para que se muestre los componentes.
                this.hasUser = true;
            });
        },
    },
    created() {
        bus.$on("showChartEvent", (show) => {
            this.showChart = show;
        });
    },
    mounted() {
        this.getUserLogged();
        this.getOfertas();
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped></style>
