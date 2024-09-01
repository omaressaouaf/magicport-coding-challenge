import Alpine from "alpinejs";

Alpine.data("tasksComponent", () => ({
    currentTask: null,
    form: {
        name: null,
        description: null,
        status: null,
    },

    setCurrentTask(task) {
        this.currentTask = task;

        this.form.name = this.currentTask.name;
        this.form.description = this.currentTask.description;
        this.form.status = this.currentTask.status;
    },
    resetForm() {
        this.form = {
            name: null,
            description: null,
            status: null,
        };
    },
    makeRequest(method, url, data) {
        return fetch(url, {
            method: method,
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": document.head.querySelector(
                    "meta[name=csrf-token]"
                ).content,
            },
        });
    },
    async deleteTask(taskId) {
        await this.makeRequest("delete", `/tasks/${taskId}`);

        this.tasks = this.tasks.filter((task) => task.id !== taskId);
    },
    async createTask() {
        let response = await this.makeRequest(
            "post",
            `/projects/${this.currentProject.id}/tasks`,
            this.form
        );

        const task = await response.json();

        this.tasks.unshift(task);
    },
    async updateTask() {
        let response = await this.makeRequest(
            "put",
            `/tasks/${this.currentTask.id}`,
            this.form
        );

        const task = await response.json();

        this.tasks = this.tasks.map((loopTask) =>
            loopTask.id === task.id ? task : loopTask
        );
    },
    async handleSubmit() {
        if (this.currentTask) {
            this.updateTask();
        } else {
            this.createTask();
        }

        this.resetForm();
    },
}));
