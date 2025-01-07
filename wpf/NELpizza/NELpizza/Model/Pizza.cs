using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NELpizza.Model
{
    [Table("pizzas")]
    public class Pizza
    {
        [Key]
        public long id { get; set; }

        public string naam { get; set; } = string.Empty;

        public virtual ICollection<IngredientPizza> ingredienten { get; set; } = new HashSet<IngredientPizza>();
    }
}