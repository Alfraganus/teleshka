<template>
  <div class="mx-4">
    <v-card-title>
      Teleshkalarni joriy tamirlash
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="ppr"
      :search="search"
      :loading="Loading"
      loading-text="Loading... Please wait"
    >
      <template v-slot:item.id="{ item }">{{ ppr.map(v => v.id).indexOf(item.id) + 1 }}</template>
      <template v-slot:item.icons="{ item }">
        <v-btn
          class="mr-4"
          color="primary"
          v-if="$user.role >= 1"
          @click="editPpr(item)"
          outlined
          small
          dark
        >
          <v-icon small>mdi-pencil</v-icon>
        </v-btn>

        <v-btn
          @click="deletePpr(item.id)"
          v-if="$user.role >= 2"
          color="primary"
          outlined
          small
          dark
        >
          <v-icon color="red" text small>mdi-delete</v-icon>
        </v-btn>
      </template>
    </v-data-table>

    <v-dialog v-model="savePprModal" persistent max-width="450px">
      <v-card>
        <v-card-title>
          <span class="headline">{{ pprTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="form.name"
                  autofocus
                  hide-details="auto"
                  label="Shift name*"
                  color="#203d5b"
                  outlined
                  dense
                  required
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions class="justify-center">
          <v-btn color="green" dark @click="savePpr">Save</v-btn>
          <v-btn color="red darken-1" dark @click="savePprModal = false">Close</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import Swal from "sweetalert2";

export default {
  data() {
    return {
      ppr: [],
      headers: [
        { text: "ID", value: "id" },
        {
          text: "Tamirlash sanasi",
          align: "start",
          value: "ppr_date"
        },
        { text: "Shift", value: "shift" },
        { text: "Tamirlovchi", value: "ppr_responsible_employee_fullname" },
        { text: "Brigadir", value: "brigadir_fullname" },
        { text: "Telly №", value: "telly_id" },
        { text: "Department", value: "department_id" },
        { text: "Tamirlangan vaqt", value: "updated_at" },
        { text: "Izox", value: "technical_review_conclusion" },
        { text: "", align: "right", value: "icons", sortable: false }
      ],
      search: "",
      Loading: true,
      name: "",
      addPprModal: false,
      savePprModal: false,
      form: {},
      pprTitle: ""
    };
  },
  methods: {
    editPpr(item) {
      this.savePprModal = true;
      this.pprTitle = "O'zgartirish";
      this.form = JSON.parse(JSON.stringify(item));
    },
    savePpr() {
      this.$axios
        .post(
          this.$store.state.backend_url + "/api/ppr/update/" + this.form.id,
          this.form
        )
        .then(response => {
          this.savePprModal = false;
          Swal.fire({
            position: "top-end",
            toast: true,
            icon: "success",
            title: "Tamirlash o'zgardi!!!",
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
          });
          this.Loading = true;
          this.getList();
          console.log(response.date);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    deletePpr(id) {
      Swal.fire({
        title: "O'chirish",
        text: "Siz ushbu tamirlashni o'chirishga aminmisiz!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "O'chirish!",
        cancelButtonText: "Yopish"
      }).then(result => {
        if (result.value) {
          this.$axios
            .delete(this.$store.state.backend_url + "/api/ppr/delete/" + id)
            .then(res => {
              this.Loading = true;
              this.getList();
              console.log(res.data);
            })
            .catch(function(error) {
              console.error(error);
            });
          Swal.fire({
            position: "top-end",
            toast: true,
            icon: "success",
            title: "O'chirildi",
            showConfirmButton: false,
            width: "250px",
            timer: 2000,
            timerProgressBar: true
          });
        }
      });
    },
    getList() {
      setTimeout(
        () =>
          this.$axios
            .get(this.$store.state.backend_url + "/api/ppr")
            .then(response => {
              this.ppr = response.data.getPpr;
              console.log(response);
              this.Loading = false;
            })
            .catch(function(error) {
              console.log(error);
            }),
        2000
      );
    }
  },
  mounted() {
    this.getList();
  }
};
</script>