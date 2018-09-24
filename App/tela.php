<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Árvore Binária</title>

    <link rel="stylesheet" href="./App/css/main.css">

</head>
<body>
    
    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="logo">
                    <h2>Árvore binária</h2>
                </div>
                <nav class="right nav">
                    <ul>
                        <li><a id="btn-existe" href="#" class="btn modal-trigger" data-modal="modal-existe">Existe <span class="key">Shift + F</span></a></li>
                        <li><a id="btn-limpar" href="?action=limpar" class="btn">Limpar <span class="key">Shift + L</span></a></li>
                        <li><a id="btn-reordenar" href="?action=reorder" class="btn">Reordenar <span class="key">Shift + R</span></a></li>
                        <li><a id="btn-add" href="#" class="btn modal-trigger" data-modal="modal-add">Adicionar <span class="key">Shift + A</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>


    <main>
        <div class="container">
            <div class="content">
                <section>
                    <h3 class="title">Dados Gerais:</h3>

                    <div id="dados-gerais">
                        <?php if(!empty($arvore_binaria->tabela)){?>
                        <table class="table">
                            <tbody>
                                <?php foreach ($arvore_binaria->tabela as $title => $content) { ?>
                                
                                <tr>
                                    <td><?= $title ?></td>
                                    <td><?= $content ?></td>
                                </tr>

                                <?php }?>
                            </tbody>
                        </table>
                        <?php }?>
                    </div>
                </section>

                <section>
                    <h3 class="title">Resumo:</h3>
                    
                    <div class="in">
                        <?php foreach($arvore_binaria->resumo as $i => $content){?>
                            <p><?= "{$content}" ?></p>
                        <?php }?>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <div class="screen-modal"></div>

    <div class="modal" id="modal-add" focused="#elemento">
        <div class="modal-header">
            <h4>Adicionar novo nó</h4>
        </div>
        <form action="?action=add" method="POST">
            <div class="modal-content">
                <div class="input-form">
                    <label for="elemento">Elemento: </label>
                    <input type="number" name="elemento" id="elemento" placeholder="Novo Elemento" required>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" value="Adicionar" class="btn btn-green">
            </div>
        </form>
    </div>

    <div class="modal" id="modal-existe" focused="#elemento-existe">
        <div class="modal-header">
            <h4>Existe nó?</h4>
        </div>
        <form action="?action=existe" method="POST">
            <div class="modal-content">
                <div class="input-form">
                    <label for="elemento">Elemento: </label>
                    <input type="number" name="elemento" id="elemento-existe" placeholder="Novo Elemento" required>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" value="Adicionar" class="btn btn-green">
            </div>
        </form>
    </div>



    <?php if(!empty($_SESSION['warning'])){?>
        <div id="toast" class="warning"><?= $_SESSION['warning'] ?></div>
        <?php unset($_SESSION['warning']);?>
    <?php }?>

    <?php if(!empty($_SESSION['success'])){?>
        <div id="toast" class="success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']);?>
    <?php }?>

    

    <script src="./App/js/main.js"></script>
</body>
</html>