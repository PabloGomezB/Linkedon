<template>
    <div>
        <h1>Ofertas por categorias</h1>

        <SelectCategoria></SelectCategoria>

        <div v-if="hasUser">
            <b-card-group deck>
                <Oferta
                    v-for="oferta in resultadoOfertas"
                    :key="oferta.id"
                    :oferta="oferta"
                    :userLogged="userLogged"
                ></Oferta>
            </b-card-group>
        </div>

        <ModalOferta
            v-if="hasUser"
            :ofertaSeleccionada="ofertaSeleccionada"
            :userLogged="userLogged"
        ></ModalOferta>
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
        };
    },
    mounted() {
        this.axios.get("/api/getUserLogged").then((response) => {
            console.log("userLogged", response.data);
            this.userLogged = response.data;
            this.hasUser = true;
        });
    },
};
</script>

<style></style>
