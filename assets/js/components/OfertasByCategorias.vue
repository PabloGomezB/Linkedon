<template>
    <div>
        <h1>Ofertas por categorias</h1>

        <SelectCategoria></SelectCategoria>

        <div>
            <b-card-group deck>
                <Oferta
                    v-for="oferta in resultadoOfertas"
                    :key="oferta.id"
                    :oferta="oferta"
                ></Oferta>
            </b-card-group>
        </div>

        <ModalOferta :ofertaSeleccionada="ofertaSeleccionada"></ModalOferta>
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
        };
    },
};
</script>

<style></style>
