<template>
    <!-- hasUser se activa cuando consigues los datos del usuario logged. Si no se pone un spinner -->
    <div v-if="hasUser">
        <h1>Ofertas por categorias</h1>
        <!-- Los eventos (@nombreEvento) sirven para poder llamar en el componente hijo al metodo del padre-->
        <!-- Por ejemplo hacemos el evento @getOfertasEvent para que obtenga 
        las ofertas otra vez de la base de datos y asi actualizar la lista de ofertas -->
        <SelectCategoria @getOfertasEvent="getOfertas()"></SelectCategoria>

        <!-- Para pasar informacion a un componente hijo ponemos ":variable" como atributo
        del componente y le añadimos la variable que queramos pasar de data() -->
        <Ofertas
            :userLogged="userLogged"
            :resultadoOfertas="resultadoOfertas"
            :key="componentKey"
            :mostrarOfertas="mostrarOfertas"
        >
        </Ofertas>
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
import Ofertas from "./Ofertas";

export default {
    name: "OfertasByCategorias",
    components: {
        SelectCategoria,
        Ofertas,
        ModalOferta,
    },

    data() {
        return {
            resultadoOfertas: {},
            //ofertaSeleccionada está puesto así para que el modal no esté montado con información undefined.
            // Hemos obtenido esta informacion desde el componente Oferta
            ofertaSeleccionada: {
                titol: "",
                empresa_id: {
                    nom: "",
                    tipus: "",
                },
                data_publicacio: "",
                ubicacio: "",
                descripcio: "",
                categoria_id: {
                    descripcio: "",
                },
            },
            userLogged: {},
            hasUser: false,
            componentKey: 0,
            mostrarOfertas: false,
        };
    },
    methods: {
        getOfertas() {
            this.mostrarOfertas = false;

            this.axios
                .get(
                    "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta?filter=estat,eq,1&join=empresa_id,empresa&join=categoria_id,categoria&order=data_publicacio,asc&filter=data_publicacio,gt," +
                        this.getDate3MonthsSubstracted()
                )
                .then((response) => {
                    console.log("ofertas por categorias", response);
                    // Guardar array de ofertas
                    this.resultadoOfertas = response.data.records;
                    this.mostrarOfertas = true;
                });
        },
        getDate3MonthsSubstracted() {
            //Metodo para obtener la fecha de hace 3 meses.
            let date = new Date();
            date.setMonth(date.getMonth() - 3);
            let month = date.getMonth() + 1;
            let day = date.getDate();
            let year = date.getFullYear();
            return year + "/" + month + "/" + day;
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
        forceRerender() {
            //Metodo para re-renderizar el componente Ofertas. Se suma +1 por ejemplo porque cuando cambias la key de ese componente se vuelve renderizar.
            this.componentKey += 1;
        },
    },
    mounted() {
        //Al montar el componente llama a los metodos. Metodo propio de Vue
        this.getUserLogged();
        this.getOfertas();
    },
};
</script>

<style></style>
