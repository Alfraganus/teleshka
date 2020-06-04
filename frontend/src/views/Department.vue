<template>
  <div class="mx-4">
    <v-card-title>
      Departmentlar
      <v-btn class="ml-8" color="success" @click="newDepartment()">Department yaratish</v-btn>
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
      :items="department"
      :search="search"
      :loading="Loading"
      loading-text="Loading... Please wait"
    >
      <template v-slot:item.id="{ item }">{{ department.map(v => v.id).indexOf(item.id) + 1 }}</template>
      <template v-slot:item.icons="{ item }">
        <v-btn class="mr-4" color="primary" @click="editDepartment(item)" outlined small dark>
          <v-icon small>mdi-pencil</v-icon>
        </v-btn>

        <v-btn @click="deleteDepartment(item.id)" color="primary" outlined small dark>
          <v-icon color="red" text small>mdi-delete</v-icon>
        </v-btn>
      </template>
    </v-data-table>

    <v-dialog v-model="saveDepartmentModal" persistent max-width="450px">
      <v-card>
        <v-card-title>
          <span class="headline">{{ departmentTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="form.name"
                  autofocus
                  hide-details="auto"
                  label="Department name*"
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
          <v-btn color="green" dark @click="saveDepartment">Save</v-btn>
          <v-btn color="red darken-1" dark @click="saveDepartmentModal = false">Close</v-btn>
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
      department: [],
      headers: [
        { text: "ID", value: "id" },
        {
          text: "Department name",
          align: "start",
          value: "name"
        },
        { text: "", align: "right", value: "icons", sortable: false }
      ],
      search: "",
      Loading: true,
      name: "",
      addDepartmentModal: false,
      saveDepartmentModal: false,
      form: {},
      departmentTitle: ""
    };
  },
  methods: {
    newDepartment() {
      this.saveDepartmentModal = true;
      this.departmentTitle = "Department qo'shish";
      this.form = {
          name: ""
      };
    },
    editDepartment(item) {
      this.saveDepartmentModal = true;
      this.departmentTitle = "O'zgartirish";
      this.form = JSON.parse(JSON.stringify(item));
    },
    saveDepartment() {
      if (!this.form.id)
        this.$axios
          .post(
            this.$store.state.backend_url + "/api/department/create",
            this.form
          )
          .then(response => {
            this.saveDepartmentModal = false;
            Swal.fire({
              position: "top-end",
              icon: "success",
              title: "Department type qo'shildi!!!",
              showConfirmButton: false,
              timer: 1500
            });
            this.Loading = true;
            this.getList();
            console.log(response.date)
          })
          .catch(function(error) {
            console.log(error);
          });
      else
        this.$axios
          .post(
            this.$store.state.backend_url +
              "/api/department/update/" +
              this.form.id,
            this.form
          )
          .then(response => {
            this.saveDepartmentModal = false;
            Swal.fire({
              position: "top-end",
              toast: true,
              icon: "success",
              title: "Department o'zgardi!!!",
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true
            });
            this.Loading = true;
            this.getList();
            console.log(response.date)
          })
          .catch(function(error) {
            console.log(error);
          });
    },
    deleteDepartment(id) {
      Swal.fire({
        title: "O'chirish",
        text: "Siz ushbu Departmentni o'chirishga aminmisiz!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "O'chirish!",
        cancelButtonText: "Yopish"
      }).then(result => {
        if (result.value) {
          this.$axios
            .delete(this.$store.state.backend_url + "/api/department/delete/" + id)
            .then(res => {
              this.department = this.department.filter(v => v.id != id);
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
            width: '250px',
            timer: 2000,
            timerProgressBar: true
          });
          this.Loading = true;
        }
      });
    },
    getList() {
      setTimeout(
        () =>
          this.$axios
            .get(this.$store.state.backend_url + "/api/department")
            .then(response => {
              this.department = response.data;
              this.Loading = false;
            })
            .catch(function(error) {
              console.log(error);
            }),
        2000
      );
    },
  },
  mounted() {
    this.getList();
  }
};
</script>