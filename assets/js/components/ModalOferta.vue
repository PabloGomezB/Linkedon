<template>
    <div>
        <b-modal
            size="lg"
            id="modal-oferta"
            hide-footer
            ref="modal-oferta"
            @hide="resetModal()"
        >
            <b-container fluid v-show="mostrarOferta" class="mb-5">
                <div class="row mb-4">
                    <div class="col">
                        <h3>{{ ofertaSeleccionada.titol }}</h3>
                        <p class="text-muted">
                            {{ ofertaSeleccionada.categoria_id.descripcio }}
                        </p>
                        <p class="text-muted">
                            {{ ofertaSeleccionada.data_publicacio }}
                        </p>
                        <div>
                            <b-button
                                @click="enviarCV()"
                                variant="danger"
                                class="w-100"
                                >¡Inscríbete!</b-button
                            >
                        </div>
                    </div>
                    <div class="col">
                        <img
                            :src="
                                require('../../uploads/logos_empresa/' +
                                    ofertaSeleccionada.empresa_id.logo)
                            "
                            class="img-fluid rounded shadow"
                        />
                    </div>
                </div>

                <p>
                    {{ ofertaSeleccionada.descripcio }}
                </p>
                <p>
                    <b-icon-geo-alt></b-icon-geo-alt>
                    {{ ofertaSeleccionada.ubicacio }}
                </p>
                <p>{{ ofertaSeleccionada.empresa_id.nom }}</p>
                <p>{{ ofertaSeleccionada.empresa_id.tipus }}</p>

                <b-form-checkbox
                    v-model="status"
                    value="accepted"
                    unchecked-value="not_accepted"
                    >Añadir carta de presentación
                </b-form-checkbox>
                <div v-if="status == 'accepted'">
                    <b-form-textarea
                        id="textarea"
                        v-model="textCarta"
                        placeholder="Escribe algo..."
                        rows="3"
                        max-rows="6"
                    ></b-form-textarea>
                </div>
            </b-container>
            <div v-show="!mostrarOferta" class="text-center my-5">
                <b-spinner label="Loading..."></b-spinner>
            </div>
        </b-modal>
    </div>
</template>

<script>
export default {
    name: "ModalOferta",
    props: {
        ofertaSeleccionada: Object,
        userLogged: Object,
    },
    data() {
        return {
            status: "not_accepted",
            textCarta: "",
            mostrarOferta: true,
        };
    },
    methods: {
        enviarCV() {
            console.log("ofertaSeleccionada_id", this.ofertaSeleccionada.id);
            console.log("userLogged_id", this.userLogged.id);
            this.$bvModal
                .msgBoxConfirm("¿Seguro que quieres enviar el CV?", {
                    title: "Porfavor confirma",
                    size: "sm",
                    buttonSize: "sm",
                    okVariant: "danger",
                    okTitle: "Si",
                    cancelTitle: "No",
                    footerClass: "p-2",
                    hideHeaderClose: false,
                    centered: true,
                })
                .then((value) => {
                    if (true == value) {
                        this.mostrarOferta = false;

                        this.axios
                            .get(
                                "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/candidat?filter=usuari_id,eq," +
                                    this.userLogged.id
                            )
                            .then((response1) => {
                                console.log(
                                    "candidat_id",
                                    response1.data.records[0].id
                                );
                                this.axios({
                                    method: "post",
                                    url: "/api/setOfertaCandidat",
                                    headers: {},
                                    data: {
                                        oferta_id: this.ofertaSeleccionada.id,
                                        candidat_id:
                                            response1.data.records[0].id,
                                        carta: this.textCarta,
                                    },
                                }).then((response2) => {
                                    console.log(
                                        "post_oferta_candidat",
                                        response2
                                    );
                                    this.$bvModal.hide("modal-oferta");
                                    this.$emit("forceRerenderEvent");
                                    this.resetModal();
                                });
                            });
                    }
                })
                .catch((err) => {
                    console.log("err", err);
                });
        },
        resetModal() {
            this.status = "not_accepted";
            this.textCarta = "";
            this.mostrarOferta = true;
        },
    },
};
</script>

<style scoped>
img {
    object-fit: cover;
}
</style>
