using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NELpizza.Model
{
    [Table("ingredients")]
    public class Ingredient
    {
        [Key]
        public long id { get; set; }

        public string naam { get; set; } = string.Empty;

        [Column(TypeName = "decimal(8,2)")]
        public decimal prijs { get; set; }

        public virtual ICollection<IngredientPizza> pizzas { get; set; } = new HashSet<IngredientPizza>();
    }
}