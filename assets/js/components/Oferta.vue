<template>
    <b-col cols="12" md="6" lg="4" class="d-flex align-items-stretch" style="position:relative">
        <!-- Al hacer click (@click)en el card pasamos la info de esa oferta hacia el modal que esta en el padre del padre de este componente -->
        <!-- Para abrir el modal hemos de poner v-b-modal.{id del modal que quieres que se muestre} como atributo) -->
        <b-card
            :title="oferta.titol"
            :sub-title="oferta.empresa_id.nom"
            :img-src="
                require('../../uploads/logos_empresa/' + oferta.empresa_id.logo)
            "
            v-b-modal.modal-oferta
            @click="pasarInfoOferta"
            :bg-variant="colorJoinBody"
            :text-variant="colorJoinText"
            class="mb-3 card-oferta"
        >
            <b-card-text>
                <p v-if="isNew === true" class="new">New &#9733;</p>
                <p>
                    {{ oferta.descripcio }}
                </p>
            </b-card-text>
            <div class="clearfix">
                <div class="float-left">
                    <small class=""
                        ><b-icon-geo-alt></b-icon-geo-alt>
                        {{ oferta.ubicacio }}</small
                    >
                </div>
                <div class="float-right">
                    <small class="">{{ haceCuantoTiempo() }}</small>
                </div>
            </div>
        </b-card>
    </b-col>
</template>

<script>
import * as moment from "moment/moment";

export default {
    name: "Oferta",
    props: { oferta: Object, userLogged: Object },
    data() {
        return {
            isNew: "",
            colorJoinBody: "",
            colorJoinText: "",
        };
    },
    methods: {
        pasarInfoOferta() {
            // $parent para pasar info al padre
            this.$parent.$parent.ofertaSeleccionada = this.oferta;
        },
        getDate15daysSubstracted() {
            return moment().subtract(15, "days");
        },
        setColorIfHasLessThan15Days() {
            // Para poner la oferta el borde de color rojo para indicar que relatiavamente nuevo (tiene menos de 15 dias).
            if (
                new Date(this.oferta.data_publicacio) >
                new Date(this.getDate15daysSubstracted())
            ) {
                this.isNew = true;
            }
        },
        setColorIfUserJoined() {
            //Pinta de azul para que sepa que el usuario logged ya se ha inscrito a esa oferta.
            this.axios
                .get(
                    "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta_candidat?join=candidat_id,candidat"
                )
                .then((response) => {
                    response.data.records.forEach((element) => {
                        if (
                            element.candidat_id.usuari_id ===
                                this.userLogged.id &&
                            element.oferta_id === this.oferta.id
                        ) {
                            this.colorJoinBody = "primary";
                            this.colorJoinText = "white";
                        }
                    });
                });
        },
        haceCuantoTiempo() {
            moment.locale("es");
            return moment(this.oferta.data_publicacio).fromNow();
        },
    },
    mounted() {
        this.setColorIfHasLessThan15Days();
        this.setColorIfUserJoined();
    },
};
</script>

<style scoped>
/* scoped para que solo afecte el estilo en este componente */
p {
    overflow: hidden;
    text-overflow: ellipsis;
}

.card-oferta {
    transition: transform 0.3s; /* Animation */
}
.card-oferta:hover {
    transform: scale(
        1.05
    ); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
}
.new{
    top:0;
    right:0;
    position:absolute;
    padding: 5px;
    background-color: #2196f3;
    color: white;
}
</style>
