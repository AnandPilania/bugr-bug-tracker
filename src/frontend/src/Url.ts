
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
        bugs: {
            create: '/bugs'
        },
        projects: {
            all: '/projects',
            create: '/projects',
            get: (id: number) => `/project/${id}`,
            getWithBugs: (id: number) => `/project/${id}/with-bugs`,
            delete: (id: number) => `/project/${id}`
        },
        statuses: {
            create: '/project/status'
        }
    },
    bugs: {
        byProject: (projectId: number) => `/bugs/${projectId}`,
        view: (id: number) => `/bug/${id}`
    },
    projects: {
        all: '/projects',
        view: (id: number) => `/project/${id}`,  // this is a function to use to generate a url
        one: '/project/:projectId'         // this is the url that the above function generates to we can navigate to it
    }
}

export default Url
