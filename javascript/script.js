const searchDepartment = document.querySelector('#searchdepartment')
if (searchDepartment) {
  searchDepartment.addEventListener('input', async function() {
    const response = await fetch('../api/api_departments.php?search=' + this.value)
    const departments = await response.json()

    const section = document.querySelector('#departments')
    section.innerHTML = ''

    for (const department of departments) {
      const article = document.createElement('article')
      const img = document.createElement('img')
      img.src = 'https://picsum.photos/200?' + department.id
      const link = document.createElement('a')
      link.href = '../pages/department.php?id=' + department.id
      link.textContent = department.name
      article.appendChild(img)
      article.appendChild(link)
      section.appendChild(article)
    }
  })
}