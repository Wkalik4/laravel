function addCategorySelectListener(selectElement) {
    selectElement.addEventListener('change', function(event) {
        const товарId = this.dataset.товарId;
        const selectedCategoryId = this.value;
        const selectedText = this.options[this.selectedIndex].text;
        const td = this.closest('td');
        const selectedCategoriesDiv = td.querySelector('.selected-categories');

        fetch(`/save_category/${товарId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    category_id: selectedCategoryId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Check if the category is already displayed
                    const categorySpan = selectedCategoriesDiv.querySelector(`span[data-category="${selectedCategoryId}"]`);

                    if (!categorySpan) {
                        // Add the category if it's not already displayed
                        const newSpan = document.createElement('span');
                        newSpan.textContent = selectedText;
                        newSpan.dataset.category = selectedCategoryId;
                        selectedCategoriesDiv.appendChild(newSpan);
                    }
                } else if (data.status === 'info' && data.message.includes('уже существует')) {
                    // Optionally, you can remove the category if it already exists
                    const categorySpan = selectedCategoriesDiv.querySelector(`span[data-category="${selectedCategoryId}"]`);
                    if (categorySpan) {
                        selectedCategoriesDiv.removeChild(categorySpan);
                    }
                } else {
                    console.error('Ошибка при сохранении категории:', data.message);
                    alert('Ошибка: ' + data.message);
                }
            })
            .catch(error => console.error('Ошибка сети:', error));
    });
}

function addImageUploadListener(imageUpload) {
    imageUpload.addEventListener('change', function(event) {
        const товарId = this.dataset.товарId;
        const selectedImage = this.files[0];
        const selectedCategorySpan = this.parentNode.querySelector('.selected-category');

        const formData = new FormData();
        formData.append('image', selectedImage);
           //  formData.append('user_id', userId); //Удалили user_id
                 console.log('Сохранение изображения: товарId = ' + товарId + ',  image = ', selectedImage);

        fetch(`/save_image/${товарId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    selectedCategorySpan.textContent = data.message;
                    selectedCategorySpan.style.display = 'inline';
                } else {
                    console.error('Ошибка при сохранении изображения:', data.message);
                    alert('Ошибка: ' + data.message);
                }
            })
            .catch(error => console.error('Ошибка сети:', error));
    });
}

document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM is ready!");

    // Инициализация для выпадающего списка
    const categorySelects = document.querySelectorAll('.categorySelect');
    categorySelects.forEach(selectElement => {
        addCategorySelectListener(selectElement);
    });

    // Инициализация для загрузки изображений
    const imageUploads = document.querySelectorAll('.imageUpload');
    imageUploads.forEach(addImageUploadListener);

});