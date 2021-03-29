<template>
    <!-- hasUser se activa cuando consigues los datos del usuario logged. Si no se pone un spinner -->
    <div>
        <h1>Ofertas por categorias</h1>
        <!-- Los eventos (@nombreEvento) sirven para poder llamar en el componente hijo al metodo del padre-->
        <!-- Por ejemplo hacemos el evento @getOfertasEvent para que obtenga 
        las ofertas otra vez de la base de datos y asi actualizar la lista de ofertas -->
        <SelectCategoria></SelectCategoria>

        <!-- Para pasar informacion a un componente hijo ponemos ":variable" como atributo
        del componente y le añadimos la variable que queramos pasar de data() -->
        <Ofertas
            :isOfertasObtenidas="isOfertasObtenidas"
            :userLogged="userLogged"
            :resultadoOfertas="ofertas"
            :key="componentKey"
        >
        </Ofertas>

        <ModalOferta
            :ofertaSeleccionada="ofertaSeleccionada"
            :userLogged="userLogged"
            @forceRerenderEvent="forceRerender()"
        ></ModalOferta>
    </div>
    <!-- <div v-else class="text-center mt-5">
        <b-spinner label="Loading..."></b-spinner>
    </div> -->
</template>

<script>
import SelectCategoria from "./SelectCategoria";
import ModalOferta from "./ModalOferta";
import Ofertas from "./Ofertas";

export default {
    name: "OfertasByCategorias",
    components: {
        SelectCategoria,
        Ofertas,
        ModalOferta,
    },
    props: {
        ofertas: Array,
        userLogged: Object,
        isOfertasObtenidas: Boolean,
    },
    data() {
        return {
            //ofertaSeleccionada está puesto así para que el modal no esté montado con información undefined.
            // Hemos obtenido esta informacion desde el componente Oferta
            ofertaSeleccionada: {
                titol: "",
                empresa_id: {
                    nom: "",
                    tipus: "",
                    logo: "admin.jpg",
                },
                data_publicacio: "",
                ubicacio: "",
                descripcio: "",
                categoria_id: {
                    descripcio: "",
                },
            },
            componentKey: 0,
        };
    },
    methods: {
        forceRerender() {
            //Metodo para re-renderizar el componente Ofertas. Se suma +1 por ejemplo porque cuando cambias la key de ese componente se vuelve renderizar.
            this.componentKey += 1;
        },
    },
};
</script>

<style></style>
