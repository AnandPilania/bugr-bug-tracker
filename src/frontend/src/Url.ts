
const Url = {
    root: '/',
    auth: {
        login: '/login',
        logout: '/logout',
        profile: '/user/profile',
        register: '/register',
    },
    api: {
        login: '/login',
        logout: '/logout',
        register: '/register',
        validateToken: '/user/validate',
        changePassword: '/user/password',
        dashboard: '/dashboard',
        projects: {
            all: '/projects',
            create: '/projects/create'
        }
    },
    bugs: {
        byProject: (projectId: number) => `/bugs/${projectId}`,
        view: (id: number) => `/bug/${id}`
    },
    projects: {
        all: '/projects',
        view: (id: number) => `/project/${id}`,
        one: '/project/:projectId'
    }
}

export default Url