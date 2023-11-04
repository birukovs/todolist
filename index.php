<?php
require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">    
    <title>To-Do List</title>
</head>
<body>
    <div class="main-section">
        <div class="add">
            <form action="other/add.php" method="POST" autocomplete="off">
            <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){?>
                <input type="text" name="title" style="border-color:rgb(236, 67, 52)" placeholder="Обязательно к заполнению"/>
                <button type="submit"><i class="fa-solid fa-plus"></i></button>
            <?php } else{?>
                <input type="text" name="title" placeholder="Напишите вашу задачу"/>
                <button type="submit"><i class="fa-solid fa-plus"></i></button>
                <?php } ?>
            </form>
        </div>
        <?php
            $todo = $conn->query("SELECT * FROM todo ORDER BY id DESC")
        ?>
        <div class="show-todo">
            <?php if($todo->rowCount() <= 0){ ?>
                <div class="todo-item">
                       <div class="empty">
                        Здесь ничего нет!
                       </div>
                </div>
            <?php } ?>

            <?php while ($otodo = $todo->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                    <span id="<?php echo $otodo['id'];?>" class="remove-to-do"><i class="fa-solid fa-xmark"></i></span>
                    <?php if($otodo['checked']){?>
                        <input type="checkbox" class="check-box" data-todo-id ="<?php echo $otodo['id'];?>"  checked />
                        <h2 class="checked"><?php echo $otodo['title']?></h2>
                    <?php }else { ?>
                        <input type="checkbox"  data-todo-id ="<?php echo $otodo['id'];?>" class="check-box"/>
                        <h2><?php echo $otodo['title']?></h2>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/b40e6c775a.js" crossorigin="anonymous"></script>
    <script src="js/jquery-3.2.1.min.js"></script>

    <script>

            $(document).ready(function(){
                $('.remove-to-do').click(function(){
                    const id = $(this).attr('id');
                    
                    $.post("other/remove.php",
                        {id:id},
                        (data) => {
                           if(data){
                            $(this).parent().hide(600);
                           }
                        }
                    );
                });

                $(".check-box").click(function(e){
                    const id = $(this).attr('data-todo-id');
                    $.post('other/check.php',
                    {id: id},
                    (data)=>{
                        if(data != 'error'){
                            const h2 = $(this).next();
                            if(data ==='1'){
                                h2.removeClass('checked');
                            }
                            else{
                                h2.addClass('checked');
                            }
                        }
                    }
                    );
                });
            });

    </script>
</body>
</html>