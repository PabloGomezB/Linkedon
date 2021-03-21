<template>
    <b-card
        :header="oferta.titol"
        v-b-modal.modal-oferta
        @click="abrirModal"
        :border-variant="color15"
        :bg-variant="colorJoinBody"
        :text-variant="colorJoinText"
    >
        <b-card-text>
            <p>
                {{ oferta.descripcio }}
            </p>
        </b-card-text>

        <template #footer>
            <small class="text-muted"
                >Data publicació: {{ oferta.data_publicacio }}</small
            >
        </template>
    </b-card>
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
        abrirModal() {
            this.$parent.ofertaSeleccionada = this.oferta;
        },
        getDate15daysSubstracted() {
            let date = new Date();
            date.setDate(date.getDate() - 15);
            return date;
        },
        setColorIfHasLessThan15Days() {
            if (
                new Date(this.oferta.data_publicacio) >
                this.getDate15daysSubstracted()
            ) {
                this.color15 = "danger";
            }
        },
        setColorIfUserJoined() {
            this.axios
                .get(
                    "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta_candidat?join=candidat_id,candidat"
                )
                .then((response) => {
                    console.log("oferta_candidat", this.userLogged.id);
                    response.data.records.forEach((element) => {
                        if (
                            element.candidat_id.usuari_id ===
                                this.userLogged.id &&
                            element.oferta_id === this.oferta.id
                        ) {
                            console.log("candidat y oferta match");
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

<style></style>
