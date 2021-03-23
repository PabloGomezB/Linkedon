<template>
    <div v-if="hasUser">
        <h1>Ofertas por categorias</h1>
        <SelectCategoria @getOfertasEvent="getOfertas()"></SelectCategoria>
        <div class="mt-3">
            <b-row :key="componentKey" align-v="stretch">
                <Oferta
                    v-for="oferta in resultadoOfertas"
                    :key="oferta.id"
                    :oferta="oferta"
                    :userLogged="userLogged"
                ></Oferta>
            </b-row>
        </div>
        <ModalOferta
            :ofertaSeleccionada="ofertaSeleccionada"
            :userLogged="userLogged"
            @getOfertasEvent="getOfertas()"
            @forceRerenderEvent="forceRerender()"
        ></ModalOferta>
    </div>
    <div v-else class="text-center mt-5">
        <b-spinner label="Loading..."></b-spinner>
    </div>
</template>

<script>
import SelectCategoria from "./SelectCategoria";
import ModalOferta from "./ModalOferta";
import Oferta from "./Oferta";

export default {
    name: "OfertasByCategorias",
    components: {
        SelectCategoria,
        Oferta,
        ModalOferta,
    },
    data() {
        return {
            resultadoOfertas: {},
            ofertaSeleccionada: {},
            userLogged: {},
            hasUser: false,
            componentKey: 0,
        };
    },
    methods: {
        getOfertas() {
            this.axios
                .get(
                    "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta?order=id,asc&filter=data_publicacio,gt," +
                        this.getDate3MonthsSubstracted()
                )
                .then((response) => {
                    console.log("ofertas por categorias", response);
                    this.resultadoOfertas = response.data.records;
                });
        },
        getDate3MonthsSubstracted() {
            let date = new Date();
            date.setMonth(date.getMonth() - 3);
            let month = date.getMonth() + 1;
            let day = date.getDate();
            let year = date.getFullYear();
            return year + "/" + month + "/" + day;
        },
        getUserLogged() {
            this.axios.get("/api/getUserLogged").then((response) => {
                console.log("userLogged", response.data);
                this.userLogged = response.data;
                this.hasUser = true;
            });
        },
        forceRerender() {
            this.componentKey += 1;
        },
    },
    mounted() {
        this.getUserLogged();
        this.getOfertas();
    },
};
</script>

<style></style>
