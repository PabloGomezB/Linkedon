<template>
    <div>
        <b-form-select
            v-model="selected"
            :options="options"
            @change="getOfertasPorCategoria()"
        ></b-form-select>
    </div>
</template>

<script>
export default {
    name: "SelectCategoria",
    data() {
        return {
            selected: null,
            options: [
                { value: null, text: "Selecciona una categoría" },
                { value: "1", text: "DAW" },
                { value: "2", text: "DAM" },
                { value: "3", text: "SMX" },
                { value: "4", text: "ASIX" },
            ],
        };
    },
    methods: {
        getOfertasPorCategoria() {
            if (this.selected == null) {
                this.getOfertas();
            } else {
                this.axios
                    .get(
                        "https://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta?filter=categoria_id,eq," +
                            this.selected
                    )
                    .then((response) => {
                        console.log(
                            "ofertas por categorias",
                            "change",
                            response
                        );
                        this.$parent.resultadoOfertas = response.data.records;
                    });
            }
        },
        getOfertas() {
            this.axios
                .get(
                    "https://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta"
                )
                .then((response) => {
                    console.log("ofertas por categorias", response);
                    this.$parent.resultadoOfertas = response.data.records;
                });
        },
    },
    mounted() {
        this.getOfertas();
    },
};
</script>

<style></style>
