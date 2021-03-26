<template>
    <b-col cols="12" sm="6" md="4">
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
            :border-variant="color15"
            :bg-variant="colorJoinBody"
            :text-variant="colorJoinText"
            class="mb-3"
        >
            <b-card-text>
                <p>
                    {{ oferta.descripcio }}
                </p>
            </b-card-text>
            <div class="clearfix">
                <div class="float-left">
                    <small class="">{{ oferta.ubicacio }}</small>
                </div>
                <div class="float-right">
                    <small class="">{{ oferta.data_publicacio }}</small>
                </div>
            </div>
            <!-- <template #footer> -->

            <!-- </template> -->
        </b-card>
    </b-col>
</template>

<script>
export default {
    name: "Oferta",
    props: { oferta: Object, userLogged: Object },
    data() {
        return {
            color15: "",
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
            let date = new Date();
            date.setDate(date.getDate() - 15);
            return date;
        },
        setColorIfHasLessThan15Days() {
            // Para poner la oferta el borde de color rojo para indicar que relatiavamente nuevo (tiene menos de 15 dias).
            if (
                new Date(this.oferta.data_publicacio) >
                this.getDate15daysSubstracted()
            ) {
                this.color15 = "danger";
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
    },
    mounted() {
        this.setColorIfHasLessThan15Days();
        this.setColorIfUserJoined();
    },
};
</script>

<style scoped>
/* scoped para que solo afecte el estilo en este componente */
/* Para que no haya un borde cuando clicas una oferta */
p {
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
