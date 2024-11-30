<?php
$db = new mysqli('192.168.199.13', 'learn', 'learn', 'learn_is64_solovev30.11');
$category = $_GET['category'];
$min_price = $_GET['min_price'];
$max_price = $_GET['max_price'];
$search = $_GET['search'];

$query = "SELECT * FROM products WHERE 1=1";

if (!empty($category)) {
    $query .= " AND category = '" . $db->real_escape_string($category)  . "'";
}
if (!empty($min_price)) {
    $query .= " AND price >= " . $min_price;
}
if (!empty($max_price)) {
    $query .= " AND price <= " . $max_price;
}
if (!empty($search)) {
    $query .= " AND name LIKE '%" . $db->real_escape_string($search)  . "%'";
}
$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Фильтры</h1>
    <form method="get" action="">
        <span>Категория:
            <select name="category">
                <option value="">Все</option>
                <option value="Electrics" <?= $category == 'Электроника' ? 'selected' : '' ?>>Электроника</option>
                <option value="Furniture" <?= $category == 'Мебель' ? 'selected' : '' ?>>Мебель</option>
                <option value="Cloth" <?= $category == 'Одежда' ? 'selected' : '' ?>>Одежда</option>
            </select>
        </span><br>
        <span>Цена от: <input type="number" name="min_price" value="<?= $min_price ?>"></span>
        <span>до: <input type="number" name="max_price" value="<?= $max_price ?>"></span><br>
        <span>Поиск: <input type="text" name="search" value="<?=$search ?>"></span><br>
        <button type="submit">Применить</button>
    </form>

    <h2>Товары</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Категория</th>
            <th>Цена</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['category'] ?></td>
                    <td><?= $row['price'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Товары не найдены</p>
        <?php endif; ?>
    </table>
</body>
</html>
<?php
$db->close();
?>