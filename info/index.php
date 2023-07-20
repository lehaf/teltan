<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Информационная");
?>

    <div class="container">
        <h2 class="mb-4 subtitle">
            <?=$APPLICATION->ShowTitle();?>
        </h2>

        <h2>Заголовок Н2</h2>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget.
        </p>

        <h3>Заголовок Н3</h3>
        <p>
            <b>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget.
            </b>
        </p>

        <h4>Заголовок Н4</h4>
        <p><em>
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facilis corrupti debitis, perspiciatis dolore illo earum soluta necessitatibus sed, fugiat ipsam deserunt repellendus sit, harum voluptatum fugit magnam. Molestias, numquam necessitatibus?
            </em></p>

        <h5>Заголовок H5</h5>
        <p>
            Lorem ipsum dolor sit amet <a href="#">consectetur</a> adipisicing elit. Totam <a href="#">mollitia</a> ab facere aut, perferendis quidem eum harum, obcaecati dicta sunt fugiat esse molestiae! Dolore a veniam deleniti impedit magnam id.
        </p>

        <h6>Заголовок H6</h6>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione facere consectetur reprehenderit hic. Modi vero cupiditate cum ducimus odio dolores perspiciatis fugiat, deserunt tempore ullam a eos architecto, inventore rem.
        </p>

        <p class="mb-3">Заглавие</p>
        <ul>
            <li>Дизайнерские проекты</li>
            <li>Жилые дома</li>

            <ul>
                <li>Один</li>
                <li>Два</li>
                <li>Три</li>
            </ul>

            <li>Прилегающая территория</li>
            <li>Материалы одного стиля</li>
            <li>Полноценный кирпич</li>
            <li>Лицевой кирпич ручной формовки</li>
        </ul>

        <p class="mb-3">Заглавие</p>
        <ol>
            <li>пункт</li>
            <li>пункт
                <ol>
                    <li>пункт</li>
                    <li>пункт</li>
                    <li>пункт
                        <ol>
                            <li>пункт</li>
                            <li>пункт</li>
                            <li>пункт</li>
                        </ol>
                    </li>
                    <li>пункт</li>
                </ol>
            </li>
            <li>пункт</li>
            <li>пункт</li>
        </ol>

        <p>Таблица без рамки</p>

        <table class="table table-hover">
            <thead class="table-active">
            <th scope="col">#</th>
            <th scope="col">Имя</th>
            <th scope="col">Фамилия</th>
            <th scope="col">Логин</th>
            <th scope="col">Пароль</th>
            </thead>
            <tbody class="">
            <tr>
                <th scope="row">1.</th>
                <td>Олег</td>
                <td>Байков</td>
                <td>Байков</td>
                <td>1111</td>
            </tr>
            <tr>
                <th scope="row">2.</th>
                <td>Олег</td>
                <td>Байков</td>
                <td>Байков</td>
                <td>1111</td>
            </tr>
            <tr>
                <th scope="row">3.</th>
                <td>Олег</td>
                <td>Байков</td>
                <td>Байков</td>
                <td>1111</td>
            </tr>
            <tr>
                <th scope="row">4.</th>
                <td>Олег</td>
                <td>Байков</td>
                <td>Байков</td>
                <td>1111</td>
            </tr>
            <tr>
                <th scope="row">5.</th>
                <td>Олег</td>
                <td>Байков</td>
                <td>Байков</td>
                <td>1111</td>
            </tr>
            <tr>
                <th scope="row">6.</th>
                <td>Олег</td>
                <td>Байков</td>
                <td>Байков</td>
                <td>1111</td>
            </tr>
            </tbody>
        </table>

        <p>
            Lorem ipsum dolor sit amet <span class="font-weight-bold">consectetur</span> adipisicing elit. Magni perferendis sequi nostrum, minima pariatur, repellendus a autem animi iusto sed inventore eum numquam voluptas architecto, distinctio harum quo explicabo voluptatum!
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Earum aliquam labore id aut, tenetur iusto laboriosam in consectetur, fuga repellat possimus eos rerum minus asperiores!
        </p>

        <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit ex unde error. Quos earum molestiae cumque tenetur. Voluptas tempore cum aspernatur, voluptatum facilis quibusdam, doloribus voluptate sint recusandae tenetur officia odio, obcaecati facere officiis id commodi rerum cumque libero? Hic voluptate nesciunt debitis. Soluta totam enim eveniet, quia asperiores at deleniti eos. Nobis dolorum eum fugit laudantium ab nostrum ea illo fuga repellendus! Dolores excepturi laboriosam explicabo aliquam aperiam. Vero deleniti nam omnis reprehenderit nostrum maxime temporibus provident aut consequatur.
        </p>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>