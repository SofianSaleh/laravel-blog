<template>
    <div>
        <div class="container">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4"
                >
                    <div class="login_header">
                        <h1>Login To Dashboard</h1>
                    </div>
                    <div class="space">
                        <Input
                            type="email"
                            v-model="data.email"
                            placeholder="Email"
                        />
                    </div>
                    <div class="space">
                        <Input
                            type="password"
                            v-model="data.password"
                            placeholder="Password"
                        />
                    </div>
                    <div class="login_footer">
                        <Button
                            type="primary"
                            :disabled="isLoginingIn"
                            :loading="isLoginingIn"
                            @click="login"
                            >Login</Button
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: {
                email: "",
                password: ""
            },
            isLoginingIn: false
        };
    },
    methods: {
        async login() {
            if (this.data.email.trim() === "")
                return this.e("Email is Required");

            if (this.data.password.trim() === "")
                return this.e("Password is Required");

            if (this.data.password.trim().length < 6)
                return this.e("Incorrect Login Details");

            this.isLoginingIn = true;

            const res = await this.callApi(
                "post",
                "/api/user/admin_login",
                this.data
            );
            if (res.status === 200) {
                this.s(res.data.msg);
                window.location = "/";
            } else {
                if (res.status === 401) {
                    this.i(res.data.msg);
                } else if (res.status === 422) {
                    for (const i in res.data.errors) {
                        this.e(res.data.errors[i][0]);
                    }
                } else {
                    this.swr();
                }
            }
            this.isLoginingIn = false;
        }
    }
};
</script>

<style scoped>
._1adminOverveiw_table_recent {
    margin: 0 auto;
    margin-top: 200px;
}

.space {
    padding-bottom: 5px;
}

.login_footer {
    padding-top: 5px;
    text-align: center;
}
.login_header {
    text-align: center;
    padding-bottom: 25px;
}
</style>
