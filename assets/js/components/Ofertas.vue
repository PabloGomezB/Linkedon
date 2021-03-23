<template>
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
</template>

<script>
import Oferta from "./Oferta";

export default {
    name: "Ofertas",
    components: {
        Oferta,
    },
    props: {
        resultadoOfertas: Array,
        userLogged: Object,
        componentKey: Number,
    },
};
</script>

<style></style>
