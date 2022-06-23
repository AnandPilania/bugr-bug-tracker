<header>
    <h1>{{page-title}}</h1>
</header>
<article>
    <form method="POST" action="/login">
        <fieldset>
            <p>
                <label>Username</label>
                <input type="text" name="username">
            </p>

            <p>
                <label>Password</label>
                <input type="password" name="password">
            </p>
            
            <p>
                <button type="submit">Log in</button>
            </p>
        </fieldset>
    </form>
</article>