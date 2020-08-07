<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
    label {
        width: 100%;
        font-size: 1rem;
    }

    .card-input-element+.card {
        height: calc(36px + 2*1rem);
        color: var(--primary);
        -webkit-box-shadow: none;
        box-shadow: none;
        border: 2px solid transparent;
        border-radius: 4px;
    }

    .card-input-element+.card:hover {
        cursor: pointer;
    }

    .card-input-element:checked+.card {
        border: 2px solid var(--primary);
        -webkit-transition: border .3s;
        -o-transition: border .3s;
        transition: border .3s;
    }

    .card-input-element:checked+.card::after {
        content: '\e5ca';
        color: #AFB8EA;
        font-family: 'Material Icons';
        font-size: 24px;
        -webkit-animation-name: fadeInCheckbox;
        animation-name: fadeInCheckbox;
        -webkit-animation-duration: .5s;
        animation-duration: .5s;
        -webkit-animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }

    @-webkit-keyframes fadeInCheckbox {
        from {
            opacity: 0;
            -webkit-transform: rotateZ(-20deg);
        }
        to {
            opacity: 1;
            -webkit-transform: rotateZ(0deg);
        }
    }

    @keyframes fadeInCheckbox {
        from {
            opacity: 0;
            transform: rotateZ(-20deg);
        }
        to {
            opacity: 1;
            transform: rotateZ(0deg);
        }
    }

</style>
<div class="container">
    <div class="row mt-4">
        <div class="col">
            <div class="jumbotron">
                <h1>Use cards as radio buttons for Bootstrap 4 - Advanced Components</h1>
                <p class="lead">by djibe.</p>
                <p class="text-muted">(thx to BS4 + Daemonite Material Design)</p>
                <h2>
                    Tutorial
                </h2>
                <ol>
                    <li>
                        Wrap a standard radio input within a <code>label</code>:<br>
                        <code>
                            &lt;label>
                            &lt;input type="radio" name="organization" class="card-input-element d-none" id="demo">
                            &lt;/label>
                        </code>
                    </li>
                    <li>
                        Set CSS property <code>display: none</code> to this radio input. Here I use Bootstrap 4 utility <code>d-none</code> class.
                    </li>
                    <li>Within this label, just after the <code>input type="radio"</code>, now add a simple div styled as a card:<br>
                        <code>&lt;div class="card card-body d-flex flex-row justify-content-between align-items-center">
                            Organization 1
                            &lt;/div></code>
                    </li>
                    <li>
                        Add some CSS (refer to this fiddle CSS) for a better look.
                    </li>
                    <li>Et voilà</li>
                </ol>
                <h2>
                    Demo
                </h2>
                <p>
                    Click on those cards to play with radios styled as cards.<br> You can remove the animated check icon effect.
                </p>
                <p class="lead">
                    Choose your Organization:
                </p>
                <label>
                    <input type="radio" name="demo" class="card-input-element d-none" id="demo1">
                    <div class="card card-body bg-light d-flex flex-row justify-content-between align-items-center">
                        Organization 1
                    </div>
                </label>
                <label class="mt-3">
                    <input type="radio" name="demo" class="card-input-element d-none" value="demo2">
                    <div class="card card-body bg-light d-flex flex-row justify-content-between align-items-center">
                        Organization 2
                    </div>
                </label>
            </div>
        </div>
    </div>
