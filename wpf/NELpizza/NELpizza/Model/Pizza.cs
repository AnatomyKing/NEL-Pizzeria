using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NELpizza.Model
{
    [Table("Pizza")]
    public class Pizza
    {
        [Key]
        public int PizzaID { get; set; }

        public string Naam { get; set; }

        public virtual ICollection<Ingredient> Ingredienten { get; set; }
    }
}
