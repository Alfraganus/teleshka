<template>
  <div class="mx-4">
    <v-card-title>
      Teleshkalarni joriy tamirlash
      <v-btn
        @click="addPpr()"
        v-if="$user.role >= 2"
        color="success"
        class="ml-4"
        dark
        outlined
        small
        icon
      >
        <v-icon text>mdi-plus-thick</v-icon>
      </v-btn>
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
          color="primary"
          v-if="$user.role >= 1"
          @click="editPpr(item)"
          outlined
          small
          dark
          icon
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
          icon
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
                  v-model="form.ppr_date"
                  autofocus
                  hide-details="auto"
                  label="Tamirlash vaqti"
                  color="#203d5b"
                  outlined
                  type="date"
                  dense
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-select
                  v-model="form.shift_id"
                  label="Shifts*"
                  hide-details="auto"
                  color="#203d5b"
                  outlined
                  :items="shift"
                  item-text="name"
                  item-value="id"
                  dense
                ></v-select>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="form.brigadir_tabel"
                  hide-details="auto"
                  label="Brigadel tabel raqami"
                  color="#203d5b"
                  outlined
                  type="number"
                  dense
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-autocomplete
                  v-model="friends"
                  :items="tellies"
                  hide-details="auto"
                  color="#203d5b"
                  label="Teleshka"
                  outlined
                  item-text="tellyInfo"
                  item-value="id"
                >
                  <template v-slot:selection="data">
                    <v-list-item-content>
                      <v-list-item-title v-html="data.item.telly_number"></v-list-item-title>
                      <v-list-item-subtitle v-html="data.item.telly_desc"></v-list-item-subtitle>
                    </v-list-item-content>
                  </template>
                  <template v-slot:item="data">
                    <template>
                      <v-list-item-content>
                        <v-list-item-title v-html="data.item.telly_number"></v-list-item-title>
                        <v-list-item-subtitle v-html="data.item.telly_desc"></v-list-item-subtitle>
                      </v-list-item-content>
                    </template>
                  </template>
                </v-autocomplete>
              </v-col>
              <v-col cols="12">
                <v-select
                  v-model="form.department_id"
                  label="Department*"
                  hide-details="auto"
                  color="#203d5b"
                  outlined
                  :items="department"
                  item-text="name"
                  item-value="id"
                  dense
                ></v-select>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  v-model="form.technical_review_conclusion"
                  hide-details="auto"
                  color="#203d5b"
                  outlined
                  dense
                  label="Description*"
                  persistent-hint
                  required
                ></v-textarea>
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
        { text: "ID", value: "id", width: 50 },
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
        { text: "", align: "right", value: "icons", sortable: false, width: 100 }
      ],
      search: "",
      Loading: true,
      name: "",
      addPprModal: false,
      savePprModal: false,
      form: {},
      pprTitle: "",
      shift: [],
      department: [],
      newPprInfo: "",
      tellies: "",
      friends: []
    };
  },
  methods: {
    addPpr(id) {
      this.savePprModal = true;
      this.pprTitle = "Teleshka tamirlashni hisobga olish";
      this.form = {
        ppr_date: "",
        shift_id: "",
        ppr_responsible_employee_tabel: this.$user.tabel_number,
        brigadir_tabel: "",
        telly_id: id,
        department_id: "",
        technical_review_conclusion: ""
      };
      this.getShiftList();
      this.getDepartmentList();
      this.getTellyList();
    },
    editPpr(item) {
      this.savePprModal = true;
      this.pprTitle = "O'zgartirish";
      this.form = JSON.parse(JSON.stringify(item));
    },
    savePpr() {
      if (!this.form.id)
        this.$axios
          .get(
            "http://wb.uzautomotors.com/api/get-all-employees/" +
              this.form.brigadir_tabel
          )
          .then(res => {
            this.newPprInfo = res.data[0];
            this.$axios
              .post(this.$store.state.backend_url + "/api/ppr/create", {
                ppr_date: this.form.ppr_date,
                shift_id: this.form.shift_id,
                ppr_responsible_employee_tabel: this.$user.tabel_number,
                ppr_responsible_employee_fullname: this.$user.fullname,
                brigadir_tabel: this.form.brigadir_tabel,
                brigadir_fullname:
                  this.newPprInfo.firstname_uz_latin +
                  " " +
                  this.newPprInfo.lastname_uz_latin +
                  " " +
                  this.newPprInfo.middlename_uz_latin,
                telly_id: this.friends,
                department_id: this.form.department_id,
                technical_review_conclusion: this.form
                  .technical_review_conclusion,
                created_at: new Date(),
                updated_at: new Date()
              })
              .then(response => {
                this.savePprModal = false;
                Swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: response.data,
                  showConfirmButton: false,
                  timer: 1500
                });
                this.getList();
              })
              .catch(function(error) {
                console.log(error);
              });
          })
          .catch(function(error) {
            console.error(error);
          });
      else
        this.$axios
          .post(
            this.$store.state.backend_url +
              "/api/tellies/update/" +
              this.form.id,
            this.form
          )
          .then(response => {
            this.saveTellyModal = false;
            Swal.fire({
              position: "top-end",
              toast: true,
              icon: "success",
              title: response.data,
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true
            });
            this.router.push("/ppr");
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
              this.ppr = response.data;
              this.Loading = false;
            })
            .catch(function(error) {
              console.log(error);
            }),
        2000
      );
    },
    getDepartmentList() {
      this.$axios
        .get(this.$store.state.backend_url + "/api/department")
        .then(response => {
          this.department = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    getShiftList() {
      this.$axios
        .get(this.$store.state.backend_url + "/api/shift")
        .then(response => {
          this.shift = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    getTellyList() {
      this.$axios
        .get(this.$store.state.backend_url + "/api/tellies")
        .then(response => {
          this.tellies = response.data.map(v => {
            v.tellyInfo = v.telly_number + ' ' + v.telly_desc;
            return v;
          });
          //console.log(response.data);
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  mounted() {
    this.getList();
    this.getTellyList();
  }
};
</script>